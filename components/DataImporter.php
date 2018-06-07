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

class DataImporter
{
    static $CACHE_KEY = 'import_info';

    private $header;
    private static $info;

    public static function getInstance()
    {
        self::$info = \Yii::$app->cache->getOrSet(self::$CACHE_KEY, function () {
            return [
                'status' => 'nothing',
                'progress' => '0',
            ];
        });
    }

    public function info($status, $progress = 0)
    {
        self::$info['status'] = $status;
        self::$info['progress'] = $progress;
        \Yii::$app->cache->set(self::$CACHE_KEY, self::$info);
    }

    public function import($file)
    {
        $this->info('importing', 0);
        $reader = IOFactory::createReaderForFile($file);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $this->buildHeader($sheet);
        foreach ($sheet->getRowIterator(2) as $i => $row) {
            $this->info('importing', ($i / $sheet->getHighestRow()));
            //campus : Campus
            $campus = Campus::find()->where(['Name' => $sheet->getCell("{$this->header('Campus')}{$i}")])->one();
            if (!$campus) {
                $campus = new Campus();
                $campus->Name = $sheet->getCell("{$this->header('Campus')}{$i}");
                $campus->save();
            }

            //School : School
            $school = School::find()->where(['Name' => $sheet->getCell("{$this->header('School')}{$i}")])->one();
            if ($school) {
                $school = new School();
                $school->Name = $sheet->getCell("{$this->header('School')}{$i}");
                $school->save();
            }

            //Department : -school, Department
            $department = Department::find()->where(['SchoolId' => $school->SchoolId, 'Name' => $sheet->getCell("{$this->header('Department')}{$i}")])->one();
            if (!$department) {
                $department = new Department();
                $department->SchoolId = $school->SchoolId;
                $department->Name = $sheet->getCell("{$this->header('Department')}{$i}");
                $department->save();
            }

            //Semester : Term seperated by space
            $term = explode(" ", $sheet->getCell("{$this->header('Term')}{$i}"));
            $season = $term[0];
            $year = $term[1];
            $semester = Semester::find()->where(['Season' => $season, 'Year' => $year])->one();
            if (!$semester) {
                $semester = new Semester();
                $semester->Year = $year;
                $semester->Season = $season;
                $semester->StartDate = '1970-01-01';
                $semester->EndDate = '1970-01-01';
                $semester->save();
            }
            //Instructor : Instructor ID, Instructor, Instructor Rank, Instructor Email
            $instructor = Instructor::find()->where(['UniversityId' => $sheet->getCell("{$this->header('Instructor ID')}{$i}")]);
            if (!$instructor) {
                $fullName = explode(',', $sheet->getCell("{$this->header('Instructor')}{$i}"));
                $instructor = new Instructor();
                $instructor->UniversityId = $sheet->getCell("{$this->header('Instructor ID')}{$i}");
                $instructor->FirstName = $fullName[1];
                $instructor->LastName = $fullName[0];
                $instructor->Email = $sheet->getCell("{$this->header('Instructor Email')}{$i}");
                $instructor->Title = 'Mr';
                $instructor->save();
            }

            //major
            $major = Major::find()->where(['shi' => ''])->one();
            if (!$major) {
                $major = new Major();
                $major->Name = ''; //TODO : need major name
                $major->DepartmentId = $department->DepartmentId;
                $major->RequiredCredits = '';//todo : need major required credits
                $major->Abbreviation = '';
            }

            //Course : Course, Title, Credits
            $course = Course::find()->where(['Letter' => $sheet->getCell("{$this->header('Course')}{$i}")])->one();
            if (!$course) {
                $course = new Course();
                $course->Letter = $sheet->getCell("{$this->header('Course')}{$i}");
                $course->Name = $sheet->getCell("{$this->header('Title')}{$i}");
                $course->Credits = $sheet->getCell("{$this->header('Credits')}{$i}");
                $course->MajorId = 0; //TODO : missing major
                $course->save();
            }

            //OfferedCourse : CRN, Section
            $offeredCourse = OfferedCourse::find()->where(['CRN' => $sheet->getCell("{$this->header('CRN')}{$i}"), 'Section' => $sheet->getCell("{$this->header('Section')}{$i}")])->one();
            if (!$offeredCourse) $offeredCourse = new OfferedCourse();
            $offeredCourse->CRN = $sheet->getCell("{$this->header('CRN')}{$i}");
            $offeredCourse->Section = $sheet->getCell("{$this->header('Section')}{$i}");
            $offeredCourse->CourseId = $course->CourseId;
            $offeredCourse->InstructorId = $instructor->InstructorId;
            $offeredCourse->SemesterId = $semester->SemesterId;
            $offeredCourse->CampusId = $campus->CampusId;
            $offeredCourse->save();
        }
        $this->info('completed', 100);
    }

    /**
     * @param Worksheet $sheet
     */
    private function buildHeader($sheet)
    {
        $this->header = [];
        foreach ($sheet->getRowIterator(1, 1) as $i => $row) {
            foreach ($row->getCellIterator() as $j => $col) {
                $this->header[$col->getValue()] = $j;
            }
        }
    }

    private function header($name)
    {
        return $this->header[$name];
    }


}