<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use app\components\Tools;
use app\models\Campus;
use app\models\Course;
use app\models\Department;
use app\models\Instructor;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\School;
use app\models\Semester;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use yii\helpers\ArrayHelper;

class DataImporter
{
    static $INFO_CACHE_KEY = 'import_info';
    static $ERRORS_CACHE_KEY = 'import_errors';

    private $header;
    private $info;
    private $errors;

    /** @var Worksheet */
    private $sheet;

    /**
     * @param null $file
     * @return DataImporter
     */
    public static function getInstance($file = null)
    {
        $importer = new DataImporter();
        $importer->info = \Yii::$app->cache->getOrSet(self::$INFO_CACHE_KEY, function () use ($file) {
            return self::defaults($file);
        });
        $importer->errors = \Yii::$app->cache->get(self::$ERRORS_CACHE_KEY);
        if ($file !== null) {
            if ($file != $importer->getFile()) {
                $importer->reset($file);
                $importer->clearErrors();
            }
        }
        return $importer;
    }

    private static function defaults($file)
    {
        return [
            'status' => 'idle',
            'progress' => '0',
            'file' => $file,
        ];
    }

    public function clearErrors()
    {
        \Yii::$app->cache->delete(self::$ERRORS_CACHE_KEY);
        $this->errors = [];
    }

    public function reset($file = null)
    {
        \Yii::$app->cache->delete(self::$INFO_CACHE_KEY);
        $this->info = self::defaults($file);
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

    public function exec()
    {
        if ($this->isImporting()) return true;
        $this->setProgress('importing', 0);
        $cr = new ConsoleRunner(['file' => '@app/yii']);
        $cr->run('import/run');
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
            $this->clearErrors();
            $this->load();
            $this->setProgress('importing', 0);
            foreach ($this->sheet->getRowIterator(2) as $i => $row) {
                $this->setProgress('importing', ($i / $this->sheet->getHighestRow()));
                //campus : Campus
                $campus = Campus::find()->where(['Name' => $this->cell('Campus', $i)])->one();
                if (!$campus) {
                    $campus = new Campus();
                    $campus->Name = $this->cell('Campus', $i);
                    $campus->save();
                }
//
//                //School : School
//                $school = School::find()->where(['Name' => $this->cell('School', $i)])->one();
//                if (!$school) {
//                    $school = new School();
//                    $school->Name = $this->cell('School', $i);
//                    $school->CreatedByUserId = 1;
//                    $school->save();
//                }
//
//                //Department : -school, Department
//                $department = Department::find()->where(['SchoolId' => $school->SchoolId, 'Name' => $this->cell('Department', $i)])->one();
//                if (!$department) {
//                    $department = new Department();
//                    $department->SchoolId = $school->SchoolId;
//                    $department->Name = $this->cell('Department', $i);
//                    $department->CreatedByUserId = 1;
//                    $department->save();
//                }

                //Semester : Term separated by space
                $term = explode(" ", $this->cell('Term', $i));
                $season = $term[0];
                $year = $term[1];
                $semester = Semester::find()->where(['Season' => $season, 'Year' => $year])->one();
                if (!$semester) {
                    $semester = new Semester();
                    $semester->Year = $year;
                    $semester->Season = $season;
                    $semester->StartDate = '1970-01-01';
                    $semester->EndDate = '1970-01-01';
                    $semester->IsCurrent = 0;
                    $semester->CreatedByUserId = 1;
                    $semester->save();
                }
                //Instructor : Instructor ID, Instructor, Instructor Rank, Instructor Email
                $universityId = $this->cell('Instructor ID', $i) ? $this->cell('Instructor ID', $i) : '-1';
                $instructor = Instructor::find()->where(['UniversityId' => $universityId])->one();
                if (!$instructor) {
                    $fullName = $this->cell('Instructor', $i) ? $this->cell('Instructor', $i) : ',';
                    $fullName = explode(',', $fullName);
                    $instructor = new Instructor();
                    $instructor->UniversityId = $universityId;
                    $instructor->FirstName = $fullName[1];
                    $instructor->LastName = $fullName[0];
                    $instructor->Email = $this->cell('Instructor Email', $i) ? $this->cell('Instructor Email', $i) : '';
                    $instructor->Title = $this->cell('Instructor', $i) ? 'Mr' : '';
                    $instructor->PhoneExtension = '';
                    $instructor->CreatedByUserId = 1;
                    $instructor->save(false);
                }

                //major
//                $major = Major::find()->where(['Name' => $this->cell('Department', $i)])->one();
//                if (!$major) {
//                    $abbr = Tools::getLetterUntilNumberFound($this->cell('Course', $i));
//                    $department = Department::find()->where("Courses like '%{$abbr}%'")->one();
//                    if (!$department) $department = Department::findOne(1);
//
//                    $major = new Major();
//                    $major->Name = $this->cell('Department', $i);
//                    $major->DepartmentId = $department->DepartmentId;
//                    $major->RequiredCredits = '150';
//                    $major->Abbreviation = '---';
//                    $major->CreatedByUserId = 1;
//                    $major->save();
//                }

                $abbr = Tools::getLetterUntilNumberFound($this->cell('Course', $i));
                $major = Major::findOne(["Abbreviation" => $abbr]);
                if (!$major) $major = Major::findOne(1);

                //Course : Course, Title, Credits
                $course = Course::find()->where(['Letter' => $this->cell('Course', $i)])->one();
                if (!$course) {
                    $course = new Course();
                    $course->Letter = $this->cell('Course', $i);
                    $course->Name = $this->cell('Title', $i);
                    $course->Credits = $this->cell('Credits', $i);
                    $course->MajorId = $major->MajorId;
                    $course->CreatedByUserId = 1;
                    $course->save();
                }

                //OfferedCourse : CRN, Section
                $offeredCourse = OfferedCourse::find()->where([
                    'CRN' => $this->cell('CRN', $i),
                    'Section' => $this->cell('Section', $i)
                ])->one();
                if (!$offeredCourse) $offeredCourse = new OfferedCourse();
                $offeredCourse->CRN = $this->cell('CRN', $i);
                $offeredCourse->Section = $this->cell('Section', $i);
                $offeredCourse->CourseId = $course->CourseId;
                $offeredCourse->InstructorId = $instructor->InstructorId;
                $offeredCourse->SemesterId = $semester->SemesterId;
                $offeredCourse->CampusId = $campus->CampusId;
                $offeredCourse->CreatedByUserId = 1;
                $offeredCourse->save();
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

    /**
     * @param string $header
     * @param int $row
     * @return mixed
     */
    private function cell($header, $row)
    {
        return $this->sheet->getCell("{$this->header($header)}{$row}")->getValue();
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

    private function header($name)
    {
        if (isset($this->header[$name])) {
            return $this->header[$name];
        }
        throw new \Exception("column <b>$name</b> does not exists<br> please check if you choose the right file");
    }


}