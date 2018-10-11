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
use app\models\Instructor;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\Semester;

class Template1Importer implements ImporterInterface
{

    /**
     * @param ImportRow $row
     * @return bool
     */
    function import($row)
    {

        //campus : Campus
        $campus = Campus::find()->where(['Name' => $row->cell('Campus')])->one();
        if (!$campus) {
            $campus = new Campus();
            $campus->Name = $row->cell('Campus');
            $campus->save();
        }
//
//                //School : School
//                $school = School::find()->where(['Name' => $row->cell('School')])->one();
//                if (!$school) {
//                    $school = new School();
//                    $school->Name = $row->cell('School');
//                    $school->CreatedByUserId = 1;
//                    $school->save();
//                }
//
//                //Department : -school, Department
//                $department = Department::find()->where(['SchoolId' => $school->SchoolId, 'Name' => $row->cell('Department')])->one();
//                if (!$department) {
//                    $department = new Department();
//                    $department->SchoolId = $school->SchoolId;
//                    $department->Name = $row->cell('Department');
//                    $department->CreatedByUserId = 1;
//                    $department->save();
//                }

        //Semester : Term separated by space
        $term = explode(" ", $row->cell('Term'));
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
        $universityId = $row->cell('Instructor ID') ? $row->cell('Instructor ID') : '-1';
        $instructor = Instructor::find()->where(['UniversityId' => $universityId])->one();
        if (!$instructor) {
            $fullName = $row->cell('Instructor') ? $row->cell('Instructor') : ',';
            $fullName = explode(',', $fullName);
            $instructor = new Instructor();
            $instructor->UniversityId = $universityId;
            $instructor->FirstName = $fullName[1];
            $instructor->LastName = $fullName[0];
            $instructor->Email = $row->cell('Instructor Email') ? $row->cell('Instructor Email') : '';
            $instructor->Title = $row->cell('Instructor') ? 'Mr' : '';
            $instructor->PhoneExtension = '';
            $instructor->CreatedByUserId = 1;
            $instructor->save(false);
        }

        //major
//                $major = Major::find()->where(['Name' => $row->cell('Department')])->one();
//                if (!$major) {
//                    $abbr = Tools::getLetterUntilNumberFound($row->cell('Course'));
//                    $department = Department::find()->where("Courses like '%{$abbr}%'")->one();
//                    if (!$department) $department = Department::findOne(1);
//
//                    $major = new Major();
//                    $major->Name = $row->cell('Department');
//                    $major->DepartmentId = $department->DepartmentId;
//                    $major->RequiredCredits = '150';
//                    $major->Abbreviation = '---';
//                    $major->CreatedByUserId = 1;
//                    $major->save();
//                }

        $abbr = Tools::getLetterUntilNumberFound($row->cell('Course'));
        $major = Major::findOne(["Abbreviation" => $abbr]);
        if (!$major) $major = Major::findOne(1);

        //Course : Course, Title, Credits
        $course = Course::find()->where(['Letter' => $row->cell('Course')])->one();
        if (!$course) {
            $course = new Course();
            $course->Letter = $row->cell('Course');
            $course->Name = $row->cell('Title');
            $course->Credits = $row->cell('Credits');
            $course->MajorId = $major->MajorId;
            $course->CreatedByUserId = 1;
            $course->save();
        }

        //OfferedCourse : CRN, Section
        $offeredCourse = OfferedCourse::find()->where([
            'CRN' => $row->cell('CRN'),
            'Section' => $row->cell('Section')
        ])->one();
        if (!$offeredCourse) $offeredCourse = new OfferedCourse();
        $offeredCourse->CRN = $row->cell('CRN');
        $offeredCourse->Section = $row->cell('Section');
        $offeredCourse->CourseId = $course->CourseId;
        $offeredCourse->InstructorId = $instructor->InstructorId;
        $offeredCourse->SemesterId = $semester->SemesterId;
        $offeredCourse->CampusId = $campus->CampusId;
        $offeredCourse->CreatedByUserId = 1;
        $offeredCourse->save();
        return true;
    }
}