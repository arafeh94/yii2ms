<?php

namespace app\controllers;

use app\models\Department;
use app\models\providers\SchoolDataProvider;
use app\models\School;
use yii\filters\AccessControl;
use yii\helpers\Json;

class SchoolController extends \yii\web\Controller
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
        $provider = new SchoolDataProvider();
        $provider->search(\Yii::$app->request->get('User', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(School::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('School')['SchoolId'];
            $model = $id === "" ? new School() : School::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model, 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (Department::find()->where(['SchoolId' => $id])->count()) {
            return false;
        }
        if (\Yii::$app->request->isAjax) {
            $model = School::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

}
