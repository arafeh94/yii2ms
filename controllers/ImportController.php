<?php

namespace app\controllers;

use app\components\DataImporter;
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

        $importer = DataImporter::getInstance();
        if (Yii::$app->request->isPost) {
            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');
            $model->template = Yii::$app->request->post('DataImportForm')['template'];
            if ($model->upload()) {
                $importer = DataImporter::getInstance($model->savedFile, $model->template);
                $importer->exec();
            }
        }
        return $this->render('index', [
            'model' => $model,
            'importer' => $importer,
            'completed' => Yii::$app->request->get('completed', false)
        ]);
    }

    public function actionCompleted()
    {
        $importer = DataImporter::getInstance();
        return $this->render('completed', ['importer' => $importer]);
    }

    public function actionProgress()
    {
        if (Yii::$app->request->isAjax) {
            $importer = DataImporter::getInstance();
            return Json::encode(['status' => $importer->getStatus(), 'progress' => $importer->getProgress()]);
        }
        return $this->redirect(['site/index', 200]);
    }
}
