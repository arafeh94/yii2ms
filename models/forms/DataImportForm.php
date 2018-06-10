<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:34 AM
 */

namespace app\models\forms;

use app\components\DataImporter;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class DataImportForm
 * @package app\models\forms
 *
 * @property String $savedFile
 */
class DataImportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $dataFile;
    private $savedName;

    public function rules()
    {
        return [
            [['dataFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $date = date('ymdhis');
            $this->savedName = "import_$date.{$this->dataFile->extension}";
            if (!file_exists('uploads')) mkdir('uploads', 0777, true);
            $this->dataFile->saveAs("uploads/{$this->savedName}");
            return true;
        } else {
            $this->addError('dataFile', 'file not uploaded');
            return false;
        }
    }

    public function getSavedFile()
    {
        return Yii::$app->basePath . "/web/uploads/{$this->savedName}";
    }

}