<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use app\models\Course;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\Semester;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentSemesterEnrollment;
use app\models\StudyPlan;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class ArrayQueries
{
    /**
     * @param $student Student
     * @return array [StudyPlanId,StudyPlanYear,StudyPlanSeason,CourseLetter,CourseName,CourseCredit,MajorCredit,StudentId,StudentCourseEnrollmentId]
     */
    public static function studyPlan($student)
    {
        $studyPlanRecords = StudyPlan::find()
            ->where(['MajorId' => $student->CurrentMajor])
            ->active()
            ->all();
        $enrolledCourses = new Query();
        $enrolledCourses = $enrolledCourses->select(['studentcourseenrollment.StudyPlanId', 'course.Name', 'course.Credits', 'major.RequiredCredits', 'StudentCourseEnrollmentId', 'studyplan.StudyPlanId', 'studyplan.Year', 'studyplan.Season', 'studyplan.CourseLetter', 'offeredcourse.Section', 'offeredcourse.Section', 'FinalGrade'])
            ->from(StudentCourseEnrollment::tableName())
            ->innerJoin(StudentSemesterEnrollment::tableName(), 'studentsemesterenrollment.StudentSemesterEnrollmentId=studentcourseenrollment.StudentSemesterEnrollmentId')
            ->innerJoin(OfferedCourse::tableName(), 'offeredcourse.OfferedCourseId=studentcourseenrollment.OfferedCourseId')
            ->innerJoin(Course::tableName(), 'offeredcourse.CourseId=course.CourseId')
            ->innerJoin(Major::tableName(), 'major.MajorId=' . $student->CurrentMajor)
            ->leftJoin(StudyPlan::tableName(), 'studentcourseenrollment.StudyPlanId=studyplan.StudyPlanId')
            ->where([
                'StudentId' => $student->StudentId,
                'offeredcourse.IsDeleted' => 0,
                'studentsemesterenrollment.IsDeleted' => 0,
                'studentcourseenrollment.IsDeleted' => 0,
                'studentcourseenrollment.IsDropped' => 0,
            ])
            ->all();
        $result = [];
        foreach ($studyPlanRecords as $studyPlanRecord) {
            $enrolledCourseIndex = false;
            foreach ($enrolledCourses as $index => $enrolledCourse) {
                if ($enrolledCourses[$index]['StudyPlanId'] == $studyPlanRecord->StudyPlanId) {
                    $enrolledCourseIndex = $index;
                    break;
                }
            }
            $result[] = [
                'StudyPlanId' => $studyPlanRecord->StudyPlanId,
                'StudyPlanYear' => $studyPlanRecord->Year,
                'StudyPlanSeason' => $studyPlanRecord->Season,
                'CourseLetter' => $studyPlanRecord->CourseLetter,
                'CourseName' => $enrolledCourseIndex === false ? null : $enrolledCourses[$enrolledCourseIndex]['Name'],
                'CourseCredit' => $enrolledCourseIndex === false ? null : $enrolledCourses[$enrolledCourseIndex]['Credits'],
                'MajorCredit' => $enrolledCourseIndex === false ? null : $enrolledCourses[$enrolledCourseIndex]['RequiredCredits'],
                'Section' => $enrolledCourseIndex === false ? null : $enrolledCourses[$enrolledCourseIndex]['Section'],
                'FinalGrade' => $enrolledCourseIndex === false ? null : $enrolledCourses[$enrolledCourseIndex]['FinalGrade'],
                'StudentCourseEnrollmentId' => !$enrolledCourseIndex ? null : $enrolledCourses[$enrolledCourseIndex]['StudentCourseEnrollmentId'],
                'StudentId' => $student->StudentId,
            ];
            if ($enrolledCourseIndex !== false) {
                unset($enrolledCourses[$enrolledCourseIndex]);
            }
        }

        foreach ($enrolledCourses as $enrolledCourse) {
            $result[] = [
                'StudyPlanId' => $enrolledCourse['StudyPlanId'],
                'StudyPlanYear' => $enrolledCourse['Year'],
                'StudyPlanSeason' => $enrolledCourse['Season'],
                'CourseLetter' => $enrolledCourse['CourseLetter'],
                'CourseName' => $enrolledCourse['Name'],
                'CourseCredit' => $enrolledCourse['Credits'],
                'MajorCredit' => $enrolledCourse['RequiredCredits'],
                'Section' => $enrolledCourse['Section'],
                'FinalGrade' => $enrolledCourse['FinalGrade'],
                'StudentId' => $student->StudentId,
                'StudentCourseEnrollmentId' => $enrolledCourse['StudentCourseEnrollmentId'],
            ];
        }
        ArrayHelper::multisort($result, ['StudyPlanYear', 'StudyPlanSeason']);
        return $result;
    }
}