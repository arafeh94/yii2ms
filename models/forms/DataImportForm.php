<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:34 AM
 */

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class DataImportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $dataFile;

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
            $this->dataFile->saveAs('uploads/' . $this->dataFile->baseName . '.' . $this->dataFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function import()
    {
        if (!$this->upload()) {
            $this->addError('dataFile', 'file not uploaded');
            return;
        }
        $file = Yii::$app->basePath . "/web/uploads/{$this->dataFile->name}";
    }



}