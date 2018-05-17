<?php

namespace app\controllers;

use app\models\Campus;
use app\models\Course;
use app\models\Instructor;
use app\models\OfferedCourse;
use app\models\providers\OfferedCourseDataProvider;
use app\models\search\OfferedCourseSearchModel;
use app\models\Semester;
use yii\helpers\Json;

class OfferedCourseController extends \yii\web\Controller
{
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
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', [
                'model' => $model,
                'campuses' => Campus::find()->active()->all(),
                'semesters' => Semester::find()->active()->all(),
                'instructors' => Instructor::find()->active()->all(),
                'courses' => Course::find()->active()->all(),
                'saved' => $saved
            ]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = OfferedCourse::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }
}
