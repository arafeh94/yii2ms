<?php

namespace app\controllers;


use app\components\Cached;
use app\components\extensions\Search;
use app\components\Tools;
use app\models\Invoice;
use app\models\Project;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ReleaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionAcceptance()
    {
        return $this->render('acceptance');
    }

    public function actionInvoice()
    {
        $invoices = [];
        $project = false;
        $model = new Search(['project_id']);
        $model->addRule(['project_id'], 'safe');
        $loaded = $model->load(Yii::$app->request->get()) && $model->validate();

        if ($loaded) {
            $invoices = Invoice::find()->project($model->toArray()['project_id'])->all();
            $project = Project::find()->id($model->toArray()['project_id'])->one();
        }

        Cached::put('print-invoice-data', $invoices);
        Cached::put('print-invoice-project', $project);

        return $this->render('invoice', ['model' => $model, 'invoices' => $invoices, 'project' => $project]);
    }

    public function actionPrintInvoice()
    {
        $invoices = Cached::get('print-invoice-data', false);
        $project = Cached::get('print-invoice-project', false);
        return $this->renderPartial('print-invoice', ['invoices' => $invoices, 'project' => $project]);
    }


}
