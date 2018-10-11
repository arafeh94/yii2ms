<?php

namespace app\controllers;

use app\models\Course;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\providers\CourseDataProvider;
use app\models\Student;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;

class CourseController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new CourseDataProvider();
        $provider->search(\Yii::$app->request->get('CourseSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Course::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Course')['CourseId'];
            $model = $id === "" ? new Course() : Course::find()->active()->id($id)->one();
            $saved = null;

            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', ['model' => $model, 'majors' => Major::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (OfferedCourse::find()->where(['CourseId' => $id])->count()) {
            return false;
        }
        if (\Yii::$app->request->isAjax) {
            $model = Course::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

    public function actionDeactivate($id)
    {

        if (\Yii::$app->request->isAjax) {
            $model = Course::findOne($id);
            $model->IsActivate = !$model->IsActivate;
            return $model->save();
        }
        return Json::encode("this course can't be deactivated");
    }

}
