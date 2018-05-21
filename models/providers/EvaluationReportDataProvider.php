<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/20/2018
 * Time: 1:32 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\components\Queries;
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
use yii\data\SqlDataProvider;
use yii\db\Query;

class EvaluationReportDataProvider extends SqlDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        $this->sql = Queries::Evaluation(Semester::find()->current()->SemesterId);
        parent::init();
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
                'label' => 'GPA',
                'class' => DataColumn::className(),
                'attribute' => 'GPA',
                'format' => ['decimal', 1]
            ],
            [
                'label' => 'Cr',
                'class' => DataColumn::className(),
                'attribute' => 'creditTaken',
            ],
            [
                'label' => 'mGPA',
                'class' => DataColumn::className(),
                'attribute' => 'mGPA',
                'format' => ['decimal', 1]
            ],
            [
                'label' => 'mCr',
                'class' => DataColumn::className(),
                'attribute' => 'majorCredit',
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