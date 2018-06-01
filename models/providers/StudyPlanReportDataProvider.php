<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/20/2018
 * Time: 1:32 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\components\Math;
use app\components\Queries;
use app\components\Tools;
use app\models\Campus;
use app\models\search\EvaluationReportSearchModel;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
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
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;

class StudyPlanReportDataProvider extends SqlDataProvider implements GridConfig
{
    public $searchModel;
    /** @var Student */
    public $student;

    public function init()
    {
        $this->sql = Queries::StudyPlan($this->student->StudentId, $this->student->CurrentMajor);
        parent::init();
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'label' => 'Year',
                'class' => DataColumn::className(),
                'attribute' => 'StudyPlanYear',
                'group' => true,
                'value' => function ($model) {
                    return \Yii::$app->params['yearSelector'][$model['StudyPlanYear']] . ' Year';
                },
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
                'groupFooter' => function ($model, $key, $index) {
                    return [
                        'mergeColumns' => [[0, 3]],
                        'content' => [
                            0 => 'Year Total:',
                            4 => Gridview::F_AVG,
                            5 => Gridview::F_SUM,
                        ],
                        'contentFormats' => [
                            4 => ['format' => 'callback', 'func' => 'avg'],
                            5 => ['format' => 'callback', 'func' => 'sum'],
                        ],
                        'options' => ['class' => 'success', 'style' => 'font-weight:bold;'],
                    ];
                },
            ],
            [
                'label' => 'Season',
                'class' => DataColumn::className(),
                'attribute' => 'StudyPlanSeason',
                'group' => true,
                'subGroupOf' => 0,
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
                'groupFooter' => function ($model, $key, $index) {
                    return [
                        'mergeColumns' => [[1, 3]],
                        'content' => [
                            1 => 'Season Total:',
                            4 => GridView::F_AVG,
                            5 => GridView::F_SUM,
                        ],
                        'contentFormats' => [
                            4 => ['format' => 'callback', 'func' => 'avg'],
                            5 => ['format' => 'callback', 'func' => 'sum'],
                        ],
                        'options' => ['class' => 'info', 'style' => 'font-weight:bold;'],
                    ];
                },
            ],
            [
                'label' => 'Course Letter',
                'class' => DataColumn::className(),
                'attribute' => 'CourseLetter',
            ],
            [
                'label' => 'Course Name',
                'class' => DataColumn::className(),
                'attribute' => 'CourseName',
                'pageSummary' => 'Total',
            ],
            [
                'label' => 'Grade',
                'class' => DataColumn::className(),
                'attribute' => 'FinalGrade',
                'pageSummary' => true,
                'pageSummaryFunc' => function ($data) {
                    return round(Math::avg($data), 2);
                }
            ],
            [
                'label' => 'Credits',
                'class' => DataColumn::className(),
                'attribute' => 'CourseCredit',
                'pageSummary' => true,
            ],
        ];
    }

    public function search($param)
    {
        $this->searchModel($param);
        if ($param) {
            $this->sql = "SELECT * FROM ($this->sql) as upper where 1=1 ";
            if (isset($param['Quarter']) && $param['Quarter']) $this->sql .= " And lower(`Quarter`) = lower('{$param["Quarter"]}')";
            if (isset($param['StudentName']) && $param['StudentName']) $this->sql .= " And lower(`StudentName`) like  lower('%{$param["StudentName"]}%')";
            if (isset($param['CampusName']) && $param['CampusName']) $this->sql .= " And lower(`CampusName`) like  lower('%{$param["CampusName"]}%')";
            if (isset($param['MajorName']) && $param['MajorName']) $this->sql .= " And lower(`MajorName`) like  lower('%{$param["MajorName"]}%')";
            if (isset($param['CourseName']) && $param['CourseName']) $this->sql .= " And lower(`CourseName`) like  lower('%{$param["CourseName"]}%')";
            if (isset($param['InstructorName']) && $param['InstructorName']) $this->sql .= " And lower(`InstructorName`) like  lower('%{$param["InstructorName"]}%')";
            if (isset($param['Grade']) && $param['Grade']) $this->sql .= " And Grade <=  '{$param["Grade"]}'";
            if (isset($param['GPA']) && $param['GPA']) $this->sql .= " And GPA <=  '{$param["GPA"]}'";
            if (isset($param['creditTaken']) && $param['creditTaken']) $this->sql .= " And creditTaken <=  '{$param["creditTaken"]}'";
            if (isset($param['mGPA']) && $param['mGPA']) $this->sql .= " And mGPA <=  '{$param["mGPA"]}'";
            if (isset($param['majorCredit']) && $param['majorCredit']) $this->sql .= " And majorCredit <=  '{$param["majorCredit"]}'";
            if (isset($param['Comment']) && $param['Comment']) $this->sql .= " And lower(Comment) like  lower('%{$param["Comment"]}%')";
        }
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