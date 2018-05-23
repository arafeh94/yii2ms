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
use yii\helpers\ArrayHelper;

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
                'label' => 'Quarter',
                'class' => DataColumn::className(),
                'attribute' => 'Quarter',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \Yii::$app->params['quarterSelector'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
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