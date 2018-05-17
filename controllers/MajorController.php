<?php

namespace app\controllers;

use app\models\Department;
use app\models\Major;
use app\models\providers\MajorDataProvider;
use app\models\search\MajorSearchModel;
use yii\helpers\Json;

class MajorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $provider = new MajorDataProvider();
        $provider->search(\Yii::$app->request->get('MajorSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Major::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Major')['MajorId'];
            $model = $id === "" ? new Major() : Major::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model, 'departments' => Department::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = Major::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }
}
