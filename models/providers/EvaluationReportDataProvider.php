<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/20/2018
 * Time: 1:32 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\components\Tools;
use app\models\Campus;
use app\models\search\EvaluationReportSearchModel;
use kartik\grid\DataColumn;
use yii\data\ActiveDataProvider;
use app\models\Course;
use app\models\Cycle;
use app\models\Department;
use app\models\EvaluationEmail;
use app\models\Instructor;
use app\models\InstructorEvaluationEmail;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\School;
use app\models\Season;
use app\models\Semester;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use app\models\StudentCourseEvaluation;
use app\models\StudentSemesterEnrollment;
use yii\db\Query;

class EvaluationReportDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = (new Query())->select([
            "concat(student.FirstName,' ',student.LastName) as `StudentName`",
            'campus.Name as `CampusName`',
            'major.Name as `MajorName`',
            'course.Name as `CourseName`',
            "concat(instructor.FirstName,' ',instructor.LastName) as `InstructorName`",
            'studentcourseevaluation.Grade as `Grade`',
            'studentcourseevaluation.InstructorNotes as `Comment`',
        ])
            ->from(StudentCourseEvaluation::tableName())
            ->innerJoin(Student::tableName(), 'student.StudentId=studentcourseevaluation.StudentId')
            ->innerJoin(StudentSemesterEnrollment::tableName(), 'student.StudentId=studentsemesterenrollment.StudentId')
            ->innerJoin(StudentCourseEnrollment::tableName(), 'studentcourseenrollment.StudentCourseEnrollmentId = studentcourseevaluation.StudentCourseEnrollmentId')
            ->innerJoin(OfferedCourse::tableName(), 'studentcourseenrollment.OfferedCourseId=offeredcourse.OfferedCourseId')
            ->innerJoin(Course::tableName(), 'offeredcourse.CourseId=course.CourseId')
            ->innerJoin(Major::tableName(), 'course.MajorId=major.MajorId')
            ->innerJoin(Instructor::tableName(), 'offeredcourse.InstructorId=instructor.InstructorId')
            ->innerJoin(Department::tableName(), 'major.DepartmentId=department.DepartmentId')
            ->innerJoin(School::tableName(), 'department.SchoolId=school.SchoolId')
            ->innerJoin(Cycle::tableName(), 'student.CycleId=cycle.CycleId')
            ->innerJoin(InstructorEvaluationEmail::tableName(), 'instructorevaluationemail.InstructorEvaluationEmailId=studentcourseevaluation.InstructorEvaluationEmailId')
            ->innerJoin(EvaluationEmail::tableName(), 'instructorevaluationemail.EvaluationEmailId = evaluationemail.EvaluationEmailId')
            ->innerJoin(Campus::tableName(), 'campus.CampusId = offeredcourse.CampusId')
            ->innerJoin(Semester::tableName(), 'semester.SemesterId = studentSemesterEnrollment.SemesterId')
            ->innerJoin(Season::tableName(), 'season.SeasonId = semester.SeasonId')
            ->where(['semester.SemesterId' => Semester::find()->current()->SemesterId])
            ->where(['offeredcourse.IsDeleted' => 0])
            ->where(['studentcourseenrollment.IsDropped' => 0])
            ->where(['studentcourseenrollment.IsDeleted' => 0])
            ->where(['studentsemesterenrollment.IsDeleted' => 0])
            ->where(['course.IsDeleted' => 0]);
        Tools::forcePrint($this->query->createCommand()->rawSql);
    }

    /**
     * @return []
     */
    public function gridColumns()
    {
        return [
            [
                'label' => 'Student',
                'class' => DataColumn::className(),
                'attribute' => 'StudentName',
            ],
            [
                'label' => 'Campus',
                'class' => DataColumn::className(),
                'attribute' => 'CampusName',
            ],
            [
                'label' => 'Major',
                'class' => DataColumn::className(),
                'attribute' => 'MajorName',
            ],
            [
                'label' => 'Course',
                'class' => DataColumn::className(),
                'attribute' => 'CourseName',
            ],
            [
                'label' => 'Instructor',
                'class' => DataColumn::className(),
                'attribute' => 'InstructorName',
            ],
            [
                'label' => 'Grade',
                'class' => DataColumn::className(),
                'attribute' => 'Grade',
            ],
            [
                'label' => 'Comment',
                'class' => DataColumn::className(),
                'attribute' => 'Comment',
            ],
        ];
    }

    public function search($param)
    {
        return null;
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new EvaluationReportSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;
    }
}