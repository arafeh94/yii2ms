<?php

namespace app\controllers;

use app\components\ConsoleRunner;
use app\components\Shell;
use app\components\Tools;
use app\models\providers\UserDataProvider;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
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
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['settings', 'change-pass'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new UserDataProvider();
        $provider->search(\Yii::$app->request->get('User', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(User::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('User')['UserId'];
            $model = $id === "" ? new User() : User::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->Password = 'default';
            if ($model->isNewRecord) $model->CreatedByUserId = User::get()->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderAjax('_form', ['model' => $model, 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $user = User::findOne($id);
            $user->IsDeleted = 1;
            return $user->save();
        }
        return false;
    }

    public function actionSettings()
    {
        $post = \Yii::$app->request->post();
        /** @var User $model */
        $model = \Yii::$app->user->identity;
        if ($model->load($post) && $model->validate()) {
            $model->save();
            \Yii::$app->user->logout();
            $this->goHome();
            \Yii::$app->end();
        }
        return $this->render('settings', ['user' => $model]);
    }

    public function actionUpdateApplication()
    {
        Shell::run('git pull && php composer.phar install && php yii migrate');
        $this->redirect(['user/settings', 'request' => '1']);
    }

}
