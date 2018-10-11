<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Campus;
use app\models\Course;
use app\models\Instructor;
use app\models\OfferedCourse;
use app\models\providers\OfferedCourseDataProvider;
use app\models\search\OfferedCourseSearchModel;
use app\models\Semester;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;

class OfferedCourseController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
        $provider = new OfferedCourseDataProvider();
        $provider->search(\Yii::$app->request->get('OfferedCourseSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(OfferedCourse::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('OfferedCourse')['OfferedCourseId'];
            $model = $id === "" ? new OfferedCourse() : OfferedCourse::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', [
                'model' => $model,
                'campuses' => Campus::find()->active()->all(),
                'semesters' => Semester::find()->active()->all(),
                'instructors' => Instructor::find()->active()->all(),
                'courses' => Course::find()->active()->activated()->all(),
                'saved' => $saved
            ]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        return OfferedCourse::findOne($id)->remove();
    }

    public function actionConfirmDeleteContent($offeredCourseId)
    {
        $offeredCourse = OfferedCourse::findOne($offeredCourseId);
        $enrollments = [];
        foreach ($offeredCourse->studentCourseEnrollments as $courseEnrollment) {
            $enrollment['student'] = $courseEnrollment->studentSemesterEnrollment->student->name;
            $enrollment['enrolledDate'] = $courseEnrollment->DateAdded;
            $enrollment['hasGrade'] = $courseEnrollment->FinalGrade != null ? "YES" : "NO";
            $enrollments[] = $enrollment;
        }
        return $this->renderAjax('_confirm_delete_content', [
            'offeredCourse' => $offeredCourse,
            'enrollments' => $enrollments
        ]);
    }

}
