<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Cycle;
use app\models\forms\DataImportForm;
use app\models\providers\CycleDataProvider;
use app\models\Student;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\UploadedFile;

class ImportController extends \yii\web\Controller
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
        $model = new DataImportForm();

        if (Yii::$app->request->isPost) {
            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');
            $file = $model->import();
        }
        return $this->render('index', ['model' => $model]);
    }

    public function import()
    {

    }


}
