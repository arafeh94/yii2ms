<?php /** @noinspection PhpUndefinedMethodInspection */

namespace app\components\extensions;

use app\components\Tools;
use app\models\ProjectPayment;
use yii\filters\AccessControl;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/20/2019
 * Time: 11:15 AM
 */
abstract class AppController extends \yii\web\Controller
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

    protected $model = null;
    protected $providersNamespace = 'app\models\providers\\';
    protected $modelNamespace = 'app\models\\';

    private function _model()
    {
        return $this->modelNamespace . $this->model;
    }

    private function _provider()
    {
        return "{$this->providersNamespace}{$this->model}DataProvider";
    }

    public function actionIndex()
    {
        $class = $this->_provider();
        $provider = null;
        if (class_exists($class)) {
            $provider = new $class();
        }
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            $class = $this->_model();
            return Json::encode($class::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post($this->model)['id'];
            $class = $this->_model();
            $model = $id === "" ? new $class() : $class::find()->active()->id($id)->one();
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
            $class = $this->_model();
            $model = $class::findOne($id);
            $model->is_deleted = 1;
            return $model->save();
        }
        return false;
    }

}