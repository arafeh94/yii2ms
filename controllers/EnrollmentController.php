<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Instructor;
use app\models\OfferedCourse;
use app\models\providers\EnrollmentDataProvider;
use app\models\providers\InstructorDataProvider;
use app\models\Semester;
use app\models\SemesterQuery;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentSemesterEnrollment;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;

class EnrollmentController extends \yii\web\Controller
{


    public function actionIndex($uid)
    {
        $student = Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $uid])->one();
        $provider = new EnrollmentDataProvider(['student' => $student]);
        $isEnrolledInSemester = StudentSemesterEnrollment::find()->innerJoinWith('student')->where(['UniversityId' => $uid, 'studentsemesterenrollment.IsDeleted' => 0])->count() > 0;
        $studentSemesterEnrollment = StudentSemesterEnrollment::find()->innerJoinWith('student')->where(['UniversityId' => $uid])->one();
        return $this->render('index', [
            'provider' => $provider,
            'student' => $student,
            'isEnrolledInSemester' => $isEnrolledInSemester,
            'studentSemesterEnrollment' => $studentSemesterEnrollment,
            'currentSemester' => Semester::find()->current(),
        ]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(StudentCourseEnrollment::find()->all());
        }
        return false;
    }

    public function actionUpdate($student)
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('StudentCourseEnrollment')['StudentCourseEnrollmentId'];
            $model = $id === "" ? new StudentCourseEnrollment() : StudentCourseEnrollment::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', [
                'model' => $model,
                'offeredCourses' => OfferedCourse::find()->with('course')->active()->all(),
                'saved' => $saved,
                'student' => Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $student])->one()
            ]);
        }
        return false;
    }

    public function actionDelete($id)
    {

        if (\Yii::$app->request->isAjax) {
            $model = StudentCourseEnrollment::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

    public function actionEnroll($studentId)
    {
        $student = Student::findOne($studentId);
        $enrollment = StudentSemesterEnrollment::find()->where(['StudentId' => $studentId])->one();
        if ($enrollment) {
            $enrollment->IsDeleted = !$enrollment->IsDeleted;
        } else {
            $enrollment = new StudentSemesterEnrollment();
            $enrollment->StudentId = $studentId;
            $enrollment->SemesterId = Semester::find()->current()->SemesterId;
            $enrollment->CreatedByUserId = Yii::$app->user->identity->UserId;
        }
        $enrollment->save();
        return $this->redirect(['enrollment/index', 'uid' => $student->UniversityId]);
    }

    public function actionRegisterCourse()
    {
        $post = Yii::$app->request->post();
        $hasEditable = ArrayHelper::getValue($post, 'hasEditable', false);
        $StudyPlanId = ArrayHelper::getValue($post, 'StudyPlanId', false);
        $OfferedCourseId = ArrayHelper::getValue($post, 'OfferedCourseId', false);
        $StudentId = ArrayHelper::getValue($post, 'StudentId', false);
        if ($hasEditable && $StudyPlanId && $OfferedCourseId && $StudentId) {
            $enrollment = new StudentCourseEnrollment();
            $enrollment->OfferedCourseId = $OfferedCourseId;
            $enrollment->CreatedByUserId = Yii::$app->user->identity->UserId;
            $enrollment->StudyPlanId = $StudyPlanId;
            $enrollment->StudentSemesterEnrollmentId = StudentSemesterEnrollment::find()->semester()->student($StudentId)->one()->StudentSemesterEnrollmentId;
            $message = '';
            if (!$enrollment->save()) {
                $errors = $enrollment->getFirstErrors();
                $message = reset($errors);
            }
            echo Json::encode(['output' => 'OK', 'message' => $message]);
            Yii::$app->end(200);
        }
        return false;
    }

    public function actionDrop($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = StudentCourseEnrollment::findOne($id);
            $model->IsDropped = !$model->IsDropped;
            return $model->save();
        }
        return false;
    }

}
