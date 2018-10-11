<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataImporter
{
    public static $TEMPLATES = [
        'tp1' => [
            'name' => 'Template 1',
            'class' => '\app\components\importers\Template1Importer',
            'columns' => ['Campus', 'Term', 'Instructor ID', 'Instructor', 'Instructor Email', 'Course', 'Title', 'Credits', 'CRN', 'Section']
        ],
        'tp2' => [
            'name' => 'Template 2',
            'class' => '\app\components\importers\Template2Importer',
            'columns' => ['School', 'Department', 'Major', 'Program Name', 'Program Code'],
        ]
    ];
    static $INFO_CACHE_KEY = 'import_info';
    static $ERRORS_CACHE_KEY = 'import_errors';

    private $header;
    private $info;
    private $errors;

    /** @var Worksheet */
    private $sheet;

    /**
     * @param String $file
     * @param String $template
     * @return DataImporter
     */
    public static function getInstance($file = null, $template = null)
    {
        $importer = new DataImporter();
        $importer->info = \Yii::$app->cache
            ->getOrSet(self::$INFO_CACHE_KEY, function () use ($file, $template) {
                return self::createInfo($file, $template);
            });
        $importer->errors = \Yii::$app->cache->get(self::$ERRORS_CACHE_KEY);
        if ($file !== null && $template !== null) {
            if ($file != $importer->getFile()) {
                $importer->reset($file, $template);
                $importer->clearErrors();
            }
        }
        return $importer;
    }

    private static function createInfo($file, $template)
    {
        return [
            'status' => 'idle',
            'progress' => '0',
            'file' => $file,
            'template' => $template,
        ];
    }

    public function clearErrors()
    {
        \Yii::$app->cache->delete(self::$ERRORS_CACHE_KEY);
        $this->errors = [];
    }

    public function reset($file = null, $template = null)
    {
        \Yii::$app->cache->delete(self::$INFO_CACHE_KEY);
        $this->info = self::createInfo($file, $template);
        \Yii::$app->cache->set(self::$INFO_CACHE_KEY, $this->info);
    }

    public function setProgress($status, $progress = 0)
    {
        $this->info['status'] = $status;
        $this->info['progress'] = $progress;
        \Yii::$app->cache->set(self::$INFO_CACHE_KEY, $this->info);
    }

    public function addError($error)
    {
        if (!$this->errors) $this->errors = [];
        $this->errors[] = $error;
        \Yii::$app->cache->set(self::$ERRORS_CACHE_KEY, $this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFile()
    {
        return $this->info['file'];
    }

    public function getProgress()
    {
        return $this->info['progress'];
    }

    public function getStatus()
    {
        return $this->info['status'];
    }

    public function getTemplate()
    {
        return $this->info['template'];
    }

    public function isImporting()
    {
        return $this->info['status'] === 'importing';
    }

    public function isCompleted()
    {
        return $this->info['status'] === 'completed';
    }


    public function isIdle()
    {
        return $this->info['status'] === 'idle';
    }


    public function exec($background = true)
    {
        if ($this->isImporting()) return true;
        $this->setProgress('importing', 0);
        if ($background) {
            $cr = new ConsoleRunner(['file' => '@app/yii']);
            $cr->run('import/run');
        } else {
            $this->import();
        }
        return true;
    }

    private function load()
    {
        $reader = IOFactory::createReaderForFile($this->getFile());
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->getFile());
        $this->sheet = $spreadsheet->getActiveSheet();
        $this->buildHeader();
    }

    public function import()
    {
        try {
            $class = self::$TEMPLATES[$this->getTemplate()]['class'];
            /** @var ImporterInterface $importClass */
            $importer = new $class();
            $this->clearErrors();
            $this->load();
            $this->setProgress('importing', 0);
            foreach ($this->sheet->getRowIterator(2) as $i => $row) {
                $progress = $i / $this->sheet->getHighestRow();
                $this->setProgress('importing', $progress);

                $importRow = new ImportRow($this->getTemplate(), $this->sheet, $this->header, $i);

                $importer->import($importRow);
            }
            $this->setProgress('completed', 1);
            return true;
        } catch (\Exception $e) {
            \Yii::error($e);
            $this->reset();
            $this->setProgress('error', 0);
            $this->addError($e->getMessage());
            return false;
        }
    }


    private function buildHeader()
    {
        $this->header = [];
        foreach ($this->sheet->getRowIterator(1, 1) as $i => $row) {
            foreach ($row->getCellIterator() as $j => $col) {
                $this->header[$col->getValue()] = $j;
            }
        }
    }


}

class ImportRow
{
    public $data = [];

    /**
     * ImportRow constructor.
     * @param $template
     * @param $sheet
     * @param $header
     * @param $pos
     * @throws \Exception
     */
    public function __construct($template, $sheet, $header, $pos)
    {
        foreach (DataImporter::$TEMPLATES[$template]['columns'] as $column) {
            $this->data[$column] = $sheet->getCell("{$this->fromHeader($header,$column)}{$pos}")->getValue();
        }
    }

    private function fromHeader($header, $name)
    {
        if (isset($header[$name])) {
            return $header[$name];
        }
        throw new \Exception("column <b>$name</b> does not exists<br> please check if you choose the right file");
    }

    public function cell($name)
    {
        return $this->data[$name];
    }
}

interface ImporterInterface
{
    /**
     * @param ImportRow $row
     * @return bool
     */
    function import($row);

}