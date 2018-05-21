<?php

namespace app\controllers;

use app\models\Department;
use app\models\providers\DepartmentDataProvider;
use app\models\School;
use app\models\search\DepartmentSearchModel;
use yii\filters\AccessControl;
use yii\helpers\Json;

class DepartmentController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new DepartmentDataProvider();
        $provider->search(\Yii::$app->request->get('DepartmentSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Department::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Department')['DepartmentId'];
            $model = $id === "" ? new Department() : Department::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model, 'schools' => School::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = Department::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

}
