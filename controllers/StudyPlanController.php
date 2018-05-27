<?php

namespace app\controllers;

use app\models\Major;
use app\models\providers\StudyPlanDataProvider;
use app\models\StudyPlan;
use yii\filters\AccessControl;
use yii\helpers\Json;

class StudyPlanController extends \yii\web\Controller
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

    public function actionIndex($major)
    {
        $model = new StudyPlan();
        $model->MajorId = $major;
        $provider = new StudyPlanDataProvider(['major' => $major]);
        $provider->search(\Yii::$app->request->get('StudyPlanSearchModel', []));
        return $this->render('index', ['provider' => $provider, 'model' => $model, 'major' => Major::findOne($major)]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(StudyPlan::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate($major)
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('StudyPlan')['StudyPlanId'];
            $model = $id === "" ? new StudyPlan() : StudyPlan::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->MajorId = $major;
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model, 'majors' => Major::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = StudyPlan::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }


}
