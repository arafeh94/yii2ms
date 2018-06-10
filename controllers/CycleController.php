<?php

namespace app\controllers;

use app\models\Cycle;
use app\models\providers\CycleDataProvider;
use app\models\Student;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;

class CycleController extends \yii\web\Controller
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
        $provider = new CycleDataProvider();
        $provider->search(\Yii::$app->request->get('Cycle', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Cycle::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Cycle')['CycleId'];
            $model = $id === "" ? new Cycle() : Cycle::find()->active()->id($id)->one();
            $saved = null;
            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', ['model' => $model, 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (Student::find()->where(['CycleId' => $id])->count()) {
            return false;
        }
        if (\Yii::$app->request->isAjax) {
            $model = Cycle::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }


}
