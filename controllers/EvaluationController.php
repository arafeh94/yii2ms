<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Course;
use app\models\Cycle;
use app\models\Department;
use app\models\EvaluationEmail;
use app\models\Instructor;
use app\models\InstructorEvaluationEmail;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\providers\CourseDataProvider;
use app\models\providers\EvaluationReportDataProvider;
use app\models\providers\EvaluationValidateDataProvider;
use app\models\providers\MailingDataProvider;
use app\models\School;
use app\models\Season;
use app\models\Semester;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentCourseEvaluation;
use app\models\StudentSemesterEnrollment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

class EvaluationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['fill'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new EvaluationReportDataProvider();
        $provider->search(\Yii::$app->request->get('EvaluationReportSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionMailing()
    {
        $provider = new MailingDataProvider();
        $provider->search(\Yii::$app->request->get('MailingSearchModel', []));
        return $this->render('mailing', ['provider' => $provider, 'semester' => Semester::find()->withSeason()->current()]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(EvaluationEmail::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {

            $id = \Yii::$app->request->post('EvaluationEmail')['EvaluationEmailId'];
            $model = $id === "" ? new EvaluationEmail() : EvaluationEmail::find()->active()->id($id)->one();
            $isNewRecord = $model->isNewRecord;
            if ($isNewRecord) {
                $model->Date = Tools::currentDate();
                $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
                $model->SemesterId = Semester::find()->current()->SemesterId;
            }
            $saved = null;

            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
                if ($saved && $isNewRecord) $this->sendInstructorEmails($model);
            }
            return $this->renderPartial('_form', ['model' => $model, 'saved' => $saved, 'semester' => Semester::find()->withSeason()->current()]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = EvaluationEmail::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

    public function actionSend($id)
    {
        $eval = InstructorEvaluationEmail::find()->active()->where(['InstructorEvaluationEmailId' => $id])->with('instructor')->one();
        $message = Yii::$app->mailer
            ->compose('evaluation/html', ['instructorEvaluationEmail' => $eval, 'instructor' => $eval->instructor])
            ->setFrom('lau@gmail.com')
            ->setTo($eval->instructor->Email)
            ->setSubject('Evaluation Fill Request');
        return $message->send();
    }

    /**
     * @param EvaluationEmail $evaluationEmail
     */
    public function sendInstructorEmails($evaluationEmail)
    {
        $instructors = Instructor::find()
            ->innerJoin(OfferedCourse::tableName(), 'instructor.InstructorId=offeredcourse.InstructorId')
            ->innerJoin(StudentCourseEnrollment::tableName(), 'studentcourseenrollment.OfferedCourseId=offeredcourse.OfferedCourseId')
            ->innerJoin(StudentSemesterEnrollment::tableName(), 'studentcourseenrollment.StudentSemesterEnrollmentId=studentsemesterenrollment.StudentSemesterEnrollmentId')
            ->where(['studentcourseenrollment.IsDeleted' => 0])
            ->andWhere(['studentcourseenrollment.IsDropped' => 0])
            ->andWhere(['studentsemesterenrollment.IsDeleted' => 0])
            ->andWhere(['offeredcourse.IsDeleted' => 0])
            ->active()
            ->all();
        foreach ($instructors as $instructor) {
            $instEvalEmail = new InstructorEvaluationEmail();
            $instEvalEmail->EvaluationEmailId = $evaluationEmail->EvaluationEmailId;
            $instEvalEmail->InstructorId = $instructor->InstructorId;
            $instEvalEmail->EvaluationCode = Tools::random();
            $instEvalEmail->save();
        }
    }

    public function actionFill($code)
    {
        $evaluations = Yii::$app->request->post('StudentCourseEvaluation', []);
        $evaluationsModels = [];

        $instructorEvaluationEmail = InstructorEvaluationEmail::find()->where(['EvaluationCode' => $code])->active()->one();
        if (!$instructorEvaluationEmail) {
            return $this->render('error', ['name' => 'Evaluation Form Error', 'message' => 'WRONG EVALUATION CODE']);
        }
        if (!$instructorEvaluationEmail->evaluationEmail->AvailableForInstructors) {
            return $this->render('error', ['name' => 'Evaluation Form Error', 'message' => 'EVALUATION FORM NOT AVAILABLE']);
        }

        if ($instructorEvaluationEmail->DateFilled) {
            return $this->render('error', ['name' => 'Evaluation Form Error', 'message' => 'EVALUATION ALREADY FILLED']);
        }

        if ($evaluations) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $hasError = false;
                foreach ($evaluations as $evaluation) {
                    $studentCourseEvaluation = new StudentCourseEvaluation();
                    if ($studentCourseEvaluation->load($evaluation, '')) {
                        if ($evaluation['StudentCourseEvaluationId']) {
                            $studentCourseEvaluation->StudentCourseEvaluationId = $evaluation['StudentCourseEvaluationId'];
                            if (!$studentCourseEvaluation->update()) $hasError = true;
                        } else {
                            if (!$studentCourseEvaluation->save()) $hasError = true;
                            if (!$hasError && $instructorEvaluationEmail->evaluationEmail->Quarter == 'Final') {
                                $studentCourseEnrollment = StudentCourseEnrollment::findOne($evaluation['StudentCourseEnrollmentId']);
                                $studentCourseEnrollment->FinalGrade = (double)($studentCourseEvaluation->Grade / 25);
                                $studentCourseEnrollment->save(false);
                            }
                        }
                        $evaluationsModels[] = $studentCourseEvaluation;
                    }
                }
                if ($hasError) {

                    $transaction->rollBack();
                } else {
                    $instructorEvaluationEmail->DateFilled = Tools::currentDate();
                    $instructorEvaluationEmail->save();
                    $transaction->commit();
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
            }

        } else {
            $enrollments = (new Query())
                ->select('*')
                ->from(StudentCourseEnrollment::tableName())
                ->innerJoin(OfferedCourse::tableName(), 'studentcourseenrollment.OfferedCourseId = offeredcourse.OfferedCourseId')
                ->innerJoin(Instructor::tableName(), 'offeredcourse.InstructorId = instructor.InstructorId')
                ->innerJoin(Course::tableName(), 'offeredcourse.CourseId = course.CourseId')
                ->innerJoin(StudentSemesterEnrollment::tableName(), 'studentcourseenrollment.StudentSemesterEnrollmentId = studentsemesterenrollment.StudentSemesterEnrollmentId')
                ->innerJoin(Student::tableName(), 'student.StudentId = studentsemesterenrollment.StudentId')
                ->orderBy('offeredcourse.CourseId')
                ->where(['studentsemesterenrollment.SemesterId' => Semester::find()->current()->SemesterId])
                ->andWhere(['instructor.InstructorId' => $instructorEvaluationEmail->InstructorId])
                ->andWhere(['instructor.IsDeleted' => 0])
                ->andWhere(['offeredcourse.IsDeleted' => 0])
                ->andWhere(['studentsemesterenrollment.IsDeleted' => 0])
                ->andWhere(['studentcourseenrollment.IsDeleted' => 0])
                ->andWhere(['studentcourseenrollment.IsDropped' => 0])
                ->select('*')
                ->all();
            foreach ($enrollments as $enrollment) {
                $studentCourseEvaluation = new StudentCourseEvaluation();
                $studentCourseEvaluation->InstructorEvaluationEmailId = $instructorEvaluationEmail->InstructorEvaluationEmailId;
                $studentCourseEvaluation->StudentCourseEnrollmentId = $enrollment['StudentCourseEnrollmentId'];
                $studentCourseEvaluation->StudentId = $enrollment['StudentId'];
                $evaluationsModels[] = $studentCourseEvaluation;
            }
        }
        return $this->render('fill', [
            'instructorEvaluationEmail' => $instructorEvaluationEmail,
            'enrollments' => $enrollments,
            'evaluations' => $evaluationsModels
        ]);
    }

    public function actionValidate($evaluationId)
    {
        return $this->renderPartial('validate', ['provider' => new EvaluationValidateDataProvider(['evaluationEmailId' => $evaluationId])]);
    }

}
