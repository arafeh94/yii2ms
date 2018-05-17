<?php

namespace app\controllers;

use app\models\Instructor;
use app\models\providers\InstructorDataProvider;
use yii\helpers\Json;

class InstructorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $provider = new InstructorDataProvider();
        $provider->search(\Yii::$app->request->get('InstructorSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Instructor::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Instructor')['InstructorId'];
            $model = $id === "" ? new Instructor() : Instructor::find()->active()->id($id)->one();
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
        if (\Yii::$app->request->isAjax) {
            $model = Instructor::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

}