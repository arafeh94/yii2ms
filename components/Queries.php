<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use app\models\Student;
use Yii;
use yii\web\Controller;

class Queries
{

    static function Evaluation($semesterId)
    {
        return <<<SQL
SELECT
  concat(student.FirstName, ' ', student.LastName)                                   AS `StudentName`,
  `Quarter`                                                                          AS `Quarter`,
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
     INNER JOIN (SELECT
                 max(sce2.StudentCourseEnrollmentId) AS max,
                 sce2.StudentSemesterEnrollmentId,
                 sce2.OfferedCourseId
               FROM studentcourseenrollment sce2
               WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
               GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
              ) AS e1 ON e1.max = sce.StudentCourseEnrollmentId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId and sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0) AS `creditTaken`,
  (SELECT sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
     INNER JOIN (SELECT
                 max(sce2.StudentCourseEnrollmentId) AS max,
                 sce2.StudentSemesterEnrollmentId,
                 sce2.OfferedCourseId
               FROM studentcourseenrollment sce2
               WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
               GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
              ) AS e1 ON e1.max = sce.StudentCourseEnrollmentId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId AND
         sc.MajorId = student.CurrentMajor and  sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0)                                          AS `majorCredit`,
  (SELECT sum(FinalGrade * Credits) / sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
     INNER JOIN (SELECT
                 max(sce2.StudentCourseEnrollmentId) AS max,
                 sce2.StudentSemesterEnrollmentId,
                 sce2.OfferedCourseId
               FROM studentcourseenrollment sce2
               WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
               GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
              ) AS e1 ON e1.max = sce.StudentCourseEnrollmentId
   WHERE sse.StudentId = student.StudentId AND sse.SemesterId = semester.SemesterId and sce.FinalGrade IS NOT NULL and sse.IsDeleted = 0 and sce.IsDeleted = 0 and sce.IsDropped = 0) AS `GPA`,
  (SELECT sum(FinalGrade * Credits) / sum(Credits)
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
     INNER JOIN (SELECT
                 max(sce2.StudentCourseEnrollmentId) AS max,
                 sce2.StudentSemesterEnrollmentId,
                 sce2.OfferedCourseId
               FROM studentcourseenrollment sce2
               WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
               GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
              ) AS e1 ON e1.max = sce.StudentCourseEnrollmentId
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
  INNER JOIN `semester` ON semester.SemesterId = studentsemesterenrollment.SemesterId
  INNER JOIN `season` ON season.SeasonId = semester.SeasonId
WHERE `course`.`IsDeleted` = 0
      AND offeredcourse.IsDeleted = 0
      AND studentcourseenrollment.IsDropped = 0
      AND studentcourseenrollment.IsDeleted = 0
      AND studentsemesterenrollment.IsDeleted = 0
      AND course.IsDeleted = 0
      AND semester.SemesterId = {$semesterId}
      ORDER BY Quarter,student.FirstName,student.LastName
SQL;
    }

    /**
     * @param $student int student id to get his study plan
     * @param $major int the major if the student, if null an additional query will be used to evaluate it
     * @return string
     */
    static function StudyPlan($student, $major = null)
    {
        if ($major === null) $major = Student::findOne($student)->CurrentMajor;
        return <<<SQL
SELECT
  s.Year as StudyPlanYear,
  s.Season as StudyPlanSeason,
  s.CourseLetter as CourseLetter,
  c.Name as CourseName,
  s4.FinalGrade as FinalGrade,
  c.Credits as CourseCredit,
  m.RequiredCredits as MajorCredit
FROM studyplan s
  INNER JOIN major m ON s.MajorId = m.MajorId
  LEFT JOIN course c
    ON c.CourseId = (
    SELECT c2.CourseId
    FROM course c2
      INNER JOIN major m2 ON c2.MajorId = m2.MajorId
      INNER JOIN offeredcourse o ON c2.CourseId = o.CourseId
      INNER JOIN studentcourseenrollment s2 ON o.OfferedCourseId = s2.OfferedCourseId
      INNER JOIN studentsemesterenrollment s3 ON s2.StudentSemesterEnrollmentId = s3.StudentSemesterEnrollmentId
      INNER JOIN (SELECT
                    max(sce2.StudentCourseEnrollmentId) AS max,
                    sce2.StudentSemesterEnrollmentId,
                    sce2.OfferedCourseId
                  FROM studentcourseenrollment sce2
                  WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
                  GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
                 ) AS e1 ON e1.max = s2.StudentCourseEnrollmentId
    WHERE (
            left(explode(s.CourseLetter, '/', 1), number_pos(explode(s.CourseLetter, '/', 1)) - 1) = m2.Abbreviation OR
            left(explode(s.CourseLetter, '/', 2), number_pos(explode(s.CourseLetter, '/', 1)) - 2) = m2.Abbreviation OR
            left(explode(s.CourseLetter, '/', 3), number_pos(explode(s.CourseLetter, '/', 1)) - 3) = m2.Abbreviation
          )
          AND (
            c2.Number REGEXP
            replace(
                right(
                    explode(s.CourseLetter, '/', 1),
                    length(explode(s.CourseLetter, '/', 1)) - number_pos(explode(s.CourseLetter, '/', 1)) + 1
                ), '-', '.'
            ) OR
            c2.Number REGEXP
            replace(
                right(
                    explode(s.CourseLetter, '/', 2),
                    length(explode(s.CourseLetter, '/', 2)) - number_pos(explode(s.CourseLetter, '/', 2)) + 1),
                '-', '.'
            ) OR
            c2.Number REGEXP
            replace(
                right(
                    explode(s.CourseLetter, '/', 3),
                    length(explode(s.CourseLetter, '/', 3)) - number_pos(explode(s.CourseLetter, '/', 3)) + 1),
                '-', '.'
            )
          )
          AND s3.StudentId = {$student} AND s3.IsDeleted = 0 AND s2.IsDeleted = 0 AND s2.IsDropped = 0 
    LIMIT 1
  )
  LEFT JOIN offeredcourse o2 ON c.CourseId = o2.CourseId
  LEFT JOIN studentcourseenrollment s4 ON o2.OfferedCourseId = s4.OfferedCourseId
  LEFT JOIN studentsemesterenrollment s5 ON s4.StudentSemesterEnrollmentId = s5.StudentSemesterEnrollmentId
WHERE m.MajorId = {$major} AND s.IsDeleted = 0
ORDER BY s.Year, s.Season
SQL;
    }
}