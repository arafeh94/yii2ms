<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/1/2018
 * Time: 4:21 PM
 */

namespace app\components\importers;


use app\components\ImporterInterface;
use app\components\ImportRow;
use app\components\Tools;
use app\models\Campus;
use app\models\Course;
use app\models\Department;
use app\models\Instructor;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\School;
use app\models\Semester;

class Template2Importer implements ImporterInterface
{

    /**
     * @param ImportRow $row
     * @return bool
     */
    function import($row)
    {
        //School : School
        $school = School::find()->where(['Name' => $row->cell('School')])->one();
        if (!$school) {
            $school = new School();
            $school->Name = $row->cell('School');
            $school->CreatedByUserId = 1;
            $school->save();
        }

        //Department : -school, Department
        $department = Department::find()->where(['SchoolId' => $school->SchoolId, 'Name' => $row->cell('Department')])->one();
        if (!$department) {
            $department = new Department();
            $department->SchoolId = $school->SchoolId;
            $department->Name = $row->cell('Department');
            $department->CreatedByUserId = 1;
            $department->save();
        }

//        major
        $major = Major::find()->where(['Name' => $this->cell('Department')])->one();
        if (!$major) {
            $abbr = Tools::getLetterUntilNumberFound($this->cell('Course'));
            $department = Department::find()->where("Courses like '%{$abbr}%'")->one();
            if (!$department) $department = Department::findOne(1);

            $major = new Major();
            $major->Name = $this->cell('Department');
            $major->DepartmentId = $department->DepartmentId;
            $major->RequiredCredits = '150';
            $major->Abbreviation = '---';
            $major->CreatedByUserId = 1;
            $major->save();
        }

        return true;
    }
}