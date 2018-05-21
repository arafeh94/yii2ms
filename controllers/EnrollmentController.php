<?php

namespace app\controllers;

use app\models\Instructor;
use app\models\OfferedCourse;
use app\models\providers\EnrollmentDataProvider;
use app\models\providers\InstructorDataProvider;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use Yii;
use yii\helpers\Json;

class EnrollmentController extends \yii\web\Controller
{
    public function actionIndex($student)
    {
        $provider = new EnrollmentDataProvider(['student' => $student]);
        return $this->render('index', ['provider' => $provider, 'student' => Student::find()->with('studentSemesterEnrollmentForCurrentSemester')->where(['UniversityId' => $student])->one()]);
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
            } else {
                die(var_dump($model->errors));
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

}
