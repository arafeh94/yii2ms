<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use app\models\Semester;
use app\models\Student;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class Queries
{

    static function Evaluation($semesterId)
    {
        return <<<SQL
SELECT
  `studentcourseevaluation`.StudentCourseEvaluationId,
  `studentcourseevaluation`.UserNote,
  `studentcourseevaluation`.AdminNote,
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
        $query = <<<SQL
SELECT *
FROM (SELECT
        s.Year            AS StudyPlanYear,
        s.Season          AS StudyPlanSeason,
        s.CourseLetter    AS CourseLetter,
        c.Name            AS CourseName,
        s4.FinalGrade     AS FinalGrade,
        c.Credits         AS CourseCredit,
        m.RequiredCredits AS MajorCredit,
        o2.Section        AS Section
      FROM studyplan s
        INNER JOIN major m ON s.MajorId = m.MajorId
        LEFT JOIN studentsemesterenrollment s5 ON s5.StudentId = {$student} AND s5.IsDeleted = 0
        LEFT JOIN studentcourseenrollment s4
          ON s5.StudentSemesterEnrollmentId = s4.StudentSemesterEnrollmentId AND s4.StudyPlanId = s.StudyPlanId AND
             s4.IsDeleted = 0 AND s4.IsDropped = 0
        LEFT JOIN offeredcourse o2 ON s4.OfferedCourseId = o2.OfferedCourseId
        LEFT JOIN course c ON c.CourseId = o2.CourseId
      WHERE m.MajorId = {$major}
            AND s.IsDeleted = 0

      UNION

      SELECT
        s7.Year            AS StudyPlanYear,
        s7.Season          AS StudyPlanSeason,
        s7.CourseLetter    AS CourseLetter,
        c2.Name            AS CourseName,
        s2.FinalGrade      AS FinalGrade,
        c2.Credits         AS CourseCredit,
        m2.RequiredCredits AS MajorCredit,
        offeredcourse.Section AS Section
      FROM offeredcourse
        INNER JOIN studentcourseenrollment s2
          ON offeredcourse.OfferedCourseId = s2.OfferedCourseId AND s2.IsDropped = 0 AND s2.IsDeleted = 0
        INNER JOIN studentsemesterenrollment s3 ON s2.StudentSemesterEnrollmentId = s3.StudentSemesterEnrollmentId
        INNER JOIN studyplan s7 ON s2.StudyPlanId = s7.StudyPlanId AND s7.MajorId IS NULL
        INNER JOIN course c2 ON offeredcourse.CourseId = c2.CourseId
        INNER JOIN student s6 ON s6.StudentId = {$student}
        INNER JOIN major m2 ON m2.MajorId = {$major}
     ) AS qr
ORDER BY qr.StudyPlanYear, qr.StudyPlanSeason
SQL;
        return $query;
    }

    public static function enrollment($student, $major)
    {
        if ($major === null) $major = Student::findOne($student)->CurrentMajor;
        $sql = <<<SQL
SELECT *
FROM (SELECT
        s.StudyPlanId     AS StudyPlanId,
        s.Year            AS StudyPlanYear,
        s.Season          AS StudyPlanSeason,
        s.CourseLetter    AS CourseLetter,
        c.Name            AS CourseName,
        c.Credits         AS CourseCredit,
        m.RequiredCredits AS MajorCredit,
        s5.StudentId      AS StudentId,
        s4.StudentCourseEnrollmentId
      FROM studyplan s
        INNER JOIN major m ON s.MajorId = m.MajorId
        LEFT JOIN studentsemesterenrollment s5 ON s5.StudentId = {$student} AND s5.IsDeleted = 0
        LEFT JOIN studentcourseenrollment s4 ON s5.StudentSemesterEnrollmentId = s4.StudentSemesterEnrollmentId AND
                                                s4.StudyPlanId = s.StudyPlanId AND s4.IsDeleted = 0 AND s4.IsDropped = 0
        LEFT JOIN offeredcourse o2 ON s4.OfferedCourseId = o2.OfferedCourseId
        LEFT JOIN course c ON c.CourseId = o2.CourseId
      WHERE m.MajorId = {$major}
            AND s.IsDeleted = 0

      UNION

      SELECT
        s7.StudyPlanId             AS StudyPlanId,
        s7.Year                    AS StudyPlanYear,
        s7.Season                  AS StudyPlanSeason,
        s7.CourseLetter            AS CourseLetter,
        c2.Name                    AS CourseName,
        c2.Credits                 AS CourseCredit,
        m2.RequiredCredits         AS MajorCredit,
        s6.StudentId               AS StudentId,
        s2.StudentCourseEnrollmentId
      FROM offeredcourse
        INNER JOIN studentcourseenrollment s2
          ON offeredcourse.OfferedCourseId = s2.OfferedCourseId AND s2.IsDropped = 0 AND s2.IsDeleted = 0
        INNER JOIN studentsemesterenrollment s3 ON s2.StudentSemesterEnrollmentId = s3.StudentSemesterEnrollmentId
        INNER JOIN studyplan s7 ON s2.StudyPlanId = s7.StudyPlanId AND s7.MajorId IS NULL
        INNER JOIN course c2 ON offeredcourse.CourseId = c2.CourseId
        INNER JOIN student s6 ON s6.StudentId = {$student}
        INNER JOIN major m2 ON m2.MajorId = {$major}
     ) AS qr
ORDER BY qr.StudyPlanYear, qr.StudyPlanSeason
SQL;
        return $sql;
    }

    public static function offeredCourses($semester = null)
    {
        if (!$semester) $semester = Semester::find()->current()->SemesterId;
        return <<<SQL
SELECT 
  OfferedCourseId,
  Section,
  c.Letter as Letter,
  c.Name as Title,
  m.Abbreviation as Major
 FROM offeredcourse
INNER JOIN course c ON offeredcourse.CourseId = c.CourseId
INNER JOIN major m ON c.MajorId = m.MajorId
WHERE offeredcourse.SemesterId = {$semester}
SQL;
    }

    private static function studentInfo1(array $layout, $student, $year, $season)
    {
        $select = ArrayHelper::getValue($layout, 'select', '');
        $where = ArrayHelper::getValue($layout, 'where', '');
        $query = <<<SQL
SELECT {$select}
   FROM studentcourseenrollment sce
     INNER JOIN studentsemesterenrollment sse ON sce.StudentSemesterEnrollmentId = sse.StudentSemesterEnrollmentId
     INNER JOIN offeredcourse sof ON sce.OfferedCourseId = sof.OfferedCourseId
     LEFT JOIN studyplan s3 ON sce.StudyPlanId = s3.StudyPlanId
     INNER JOIN semester s ON sse.SemesterId = s.SemesterId
     INNER JOIN course sc ON sof.CourseId = sc.CourseId
     INNER JOIN (SELECT
                 max(sce2.StudentCourseEnrollmentId) AS max,
                 sce2.StudentSemesterEnrollmentId,
                 sce2.OfferedCourseId
               FROM studentcourseenrollment sce2
               WHERE sce2.IsDeleted = 0 AND sce2.IsDropped = 0
               GROUP BY sce2.StudentSemesterEnrollmentId, sce2.OfferedCourseId
              ) AS e1 ON e1.max = sce.StudentCourseEnrollmentId
   WHERE sse.StudentId = {$student->StudentId}  
   AND sse.IsDeleted = 0 
   AND sce.IsDeleted = 0 
   AND sce.IsDropped = 0
  {$where}
SQL;

        if ($season) {
            $query .= " and if(s3.Season is null,lower(s.Season) = lower('{$season}'), lower(s3.Season) = lower('{$season}'))";
        }

        if ($year) {
            $query .= " and if(s3.Year is null, s.Year = '{$year}', s3.Year = '{$year}')";
        }

        return $query;
    }

    /**
     * @param $student Student
     * @param null $year
     * @param null $season
     * @return string
     */
    public static function gpa($student, $year = null, $season = null)
    {
        return self::studentInfo1([
            'select' => "ROUND(sum(FinalGrade * Credits) / sum(Credits),1) as GPA",
            'where' => 'AND sce.FinalGrade IS NOT NULL'
        ], $student, $year, $season);
    }

    /**
     * @param $student Student
     * @param null $year
     * @param null $season
     * @return string
     */
    public static function mgpa($student, $year = null, $season = null)
    {
        return self::studentInfo1([
            'select' => 'ROUND(sum(FinalGrade * Credits) / sum(Credits),1) as MGPA',
            'where' => "AND sc.MajorId = {$student->CurrentMajor} AND sce.FinalGrade IS NOT NULL"
        ], $student, $year, $season);
    }

    public static function credits($student, $year = null, $season = null)
    {
        return self::studentInfo1([
            'select' => 'sum(Credits)',
        ], $student, $year, $season);
    }


    public static function passedCredits($student, $year = null, $season = null)
    {
        return self::studentInfo1([
            'select' => 'sum(Credits) as PassedCredits',
            'where' => "AND sce.FinalGrade IS NOT NULL AND sce.FinalGrade > 0"
        ], $student, $year, $season);
    }
}