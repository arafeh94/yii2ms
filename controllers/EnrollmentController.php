<?php

namespace app\controllers;

use app\models\Instructor;
use app\models\OfferedCourse;
use app\models\providers\EnrollmentDataProvider;
use app\models\providers\InstructorDataProvider;
use app\models\Semester;
use app\models\SemesterQuery;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentSemesterEnrollment;
use Yii;
use yii\helpers\Json;

class EnrollmentController extends \yii\web\Controller
{
    public function actionIndex($student)
    {
        $model2 = new StudentSemesterEnrollment();
        if (Yii::$app->request->isPost) {
            $id2 = \Yii::$app->request->post('StudentSemesterEnrollment')['StudentSemesterEnrollmentId'];
            $model2 = $id2 == "" ? new StudentSemesterEnrollment() : StudentSemesterEnrollment::find()->id($id2)->one();

            if ($id2 == "") {
                if ($model2->isNewRecord) {
                    $model2->CreatedByUserId = \Yii::$app->user->identity->UserId;
                    $model2->StudentId = Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $student])->one()->StudentId;
                    $model2->SemesterId = Semester::find()->current()->SemesterId;
                }
                $saved2 = null;
                if ($model2->load(\Yii::$app->request->post()) && $model2->validate()) {
                    $saved2 = $model2->save();
                } else {
                    die(var_dump($model2->StudentId));
                }
            } else {
                $model2->IsDeleted = $model2->IsDeleted ? 0 : 1;
                if ($model2->validate()) {
                    $saved2 = $model2->save();
                } else {
                    die(var_dump($model2->error));
                }
            }
        }

        $provider = new EnrollmentDataProvider(['student' => $student]);
        $isEnrolledInSemester = StudentSemesterEnrollment::find()->innerJoinWith('student')->where(['UniversityId' => $student, 'studentsemesterenrollment.IsDeleted' => 0])->count() > 0;
        $studentSemesterEnrollment = StudentSemesterEnrollment::find()->innerJoinWith('student')->where(['UniversityId' => $student])->one();
        return $this->render('index', ['model2' => $model2, 'provider' => $provider, 'student' => Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $student])->one(), 'isEnrolledInSemester' => $isEnrolledInSemester, 'studentSemesterEnrollment' => $studentSemesterEnrollment]);
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
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model, 'offeredCourses' => OfferedCourse::find()->with('course')->active()->all(), 'saved' => $saved, 'student' => Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $student])->one()]);
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
        return $this->redirect(['enrollment/index', 'student' => $student->UniversityId]);
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
