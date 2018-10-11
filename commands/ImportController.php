<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\DataImporter;
use app\components\Tools;
use Yii;
use yii\console\Controller;

class ImportController extends Controller
{
    /**
     * import the file cached in the DataImporter existed after file upload
     */
    public function actionRun()
    {
        $importer = DataImporter::getInstance();
        if ($importer->getFile() == null) {
            throw new \Exception('file not set');
        }
        $importer->import();
    }

    /**
     * import the file cached in the DataImporter existed after file upload
     */
    public function actionReset()
    {
        $importer = DataImporter::getInstance();
        $importer->reset();
        $importer->clearErrors();
    }

    public function actionTest($file, $type)
    {
        $file = Yii::$app->basePath . "/web/uploads/{$file}";
        DataImporter::getInstance()->reset();
        $importer = DataImporter::getInstance($file, $type);
        $importer->import();
    }

    public function actionInfo()
    {
        $importer = DataImporter::getInstance();
        echo "file: {$importer->getFile()}\n";
        echo "type: {$importer->getTemplate()}\n";
        echo "status: {$importer->getStatus()}\n";
        echo "progress: {$importer->getProgress()}\n";
        echo "errors : " . print_r($importer->getErrors(), true);
    }
}
