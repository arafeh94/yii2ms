<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use Yii;
use yii\web\Controller;

class Queries
{

    static function Evaluation($semesterId)
    {
        return <<<SQL
SELECT
  concat(student.FirstName, ' ', student.LastName)                                   AS `StudentName`,
  `campus`.Name                                                                      AS `CampusName`,
  `major`.Name                                                                       AS `MajorName`,
  `course`.Name                                                                      AS `CourseName`,
  concat(instructor.FirstName, ' ', instructor.LastName)                             AS `InstructorName`,
  `studentcourseevaluation`.Grade                                                    AS `Grade`,
  `studentcourseevaluation`.InstructorNotes                                          AS `Comment`,
  (SELECT sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId and sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0) AS `creditTaken`,
  (SELECT sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId AND
         sc.MajorId = student.CurrentMajor and  sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0)                                          AS `majorCredit`,
  (SELECT sum(FinalGrade * Credits) / sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId and sce.FinalGrade IS NOT NULL and sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0) AS `GPA`,
  (SELECT sum(FinalGrade * Credits) / sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId AND
         sc.MajorId = student.CurrentMajor and sce.FinalGrade IS NOT NULL and sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0)                                          AS `mGPA`
FROM `studentcourseevaluation`
  INNER JOIN `student` ON student.StudentId = studentcourseevaluation.StudentId
  INNER JOIN `studentsemesterenrollment` ON student.StudentId = studentsemesterenrollment.StudentId
  INNER JOIN `studentcourseenrollment`
    ON studentcourseenrollment.StudentCourseEnrollmentId = studentcourseevaluation.StudentCourseEnrollmentId
  INNER JOIN `offeredcourse` ON studentcourseenrollment.OfferedCourseId = offeredcourse.OfferedCourseId
  INNER JOIN `course` ON offeredcourse.CourseId = course.CourseId
  INNER JOIN `major` ON course.MajorId = major.MajorId
  INNER JOIN `instructor` ON offeredcourse.InstructorId = instructor.InstructorId
  INNER JOIN `department` ON major.DepartmentId = department.DepartmentId
  INNER JOIN `school` ON department.SchoolId = school.SchoolId
  INNER JOIN `cycle` ON student.CycleId = cycle.CycleId
  INNER JOIN `instructorevaluationemail`
    ON instructorevaluationemail.InstructorEvaluationEmailId = studentcourseevaluation.InstructorEvaluationEmailId
  INNER JOIN `evaluationemail` ON instructorevaluationemail.EvaluationEmailId = evaluationemail.EvaluationEmailId
  INNER JOIN `campus` ON campus.CampusId = offeredcourse.CampusId
  INNER JOIN `semester` ON semester.SemesterId = studentSemesterEnrollment.SemesterId
  INNER JOIN `season` ON season.SeasonId = semester.SeasonId
WHERE `course`.`IsDeleted` = 0
      AND offeredcourse.IsDeleted = 0
      AND studentcourseenrollment.IsDropped = 0
      AND studentcourseenrollment.IsDeleted = 0
      AND studentsemesterenrollment.IsDeleted = 0
      AND course.IsDeleted = 0
      AND semester.SemesterId = {$semesterId}
SQL;
    }

}