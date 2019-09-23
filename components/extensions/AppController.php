<?php /** @noinspection PhpUndefinedMethodInspection */

namespace app\components\extensions;

use app\components\ModelView;
use app\components\Tools;
use app\models\Project;
use app\models\ProjectPayment;
use kartik\grid\EditableColumnAction;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/20/2019
 * Time: 11:15 AM
 */
abstract class AppController extends \yii\web\Controller
{

    protected $model = null;
    protected $providersNamespace = 'app\models\providers\\';
    protected $modelNamespace = 'app\models\\';


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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'edit' => [                                       // identifier for your editable column action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => $this->_model(),                // the model for the record being edited
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => '']                // error summary HTML options
            ]
        ]);
    }

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
        $class = $this->_model();
        $model = $class::find()->active()->filter()->id($id)->one();
        if (\Yii::$app->request->isAjax) {
            return Json::encode($model);
        }
        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $id = \Yii::$app->request->post($this->model)['id'];
        $class = $this->_model();
        $model = $id === "" ? new $class() : $class::find()->active()->id($id)->one();
        $saved = null;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $saved = $model->save();
        }
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', ['model' => $model, 'saved' => $saved]);
        }

        return $this->render('_form', ['model' => $model, 'saved' => $saved]);
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

    public function actionDetail()
    {
        $id = \Yii::$app->request->post('expandRowKey');
        $model = $this->getModelDetails($id);
        try {
            return $this->renderPartial('detail', ['model' => $model]);
        } catch (\Exception $e) {
            return ModelView::widget(['model' => $model]);
        }
    }


    /**
     * @param $id
     * @return ActiveRecord
     */
    public function getModelDetails($id)
    {
        $class = $this->_model();
        $detail = $class::find()->id($id)->one();
        return $detail;
    }
}