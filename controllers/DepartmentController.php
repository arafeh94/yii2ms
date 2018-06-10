<?php

namespace app\controllers;

use app\models\Department;
use app\models\Major;
use app\models\providers\DepartmentDataProvider;
use app\models\School;
use app\models\search\DepartmentSearchModel;
use app\models\User;
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
            $saved = null;
            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', ['model' => $model, 'schools' => School::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (Major::find()->where(['DepartmentId' => $id])->count()) {
            return false;
        }
        if (\Yii::$app->request->isAjax) {
            $model = Department::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

}
