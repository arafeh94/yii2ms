<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\Cached;
use app\components\GridConfig;
use app\components\Math;
use app\components\Queries;
use app\components\Tools;
use app\models\Campus;
use app\models\Course;
use app\models\Department;
use app\models\Instructor;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use app\models\search\OfferedCourseSearchModel;
use app\models\Student;
use app\models\StudentCourseEnrollment;
use kartik\editable\Editable;
use kartik\form\ActiveForm;
use kartik\grid\DataColumn;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class EnrollmentDataProvider extends SqlDataProvider implements GridConfig
{
    public $searchModel;
    /** @var Student */
    public $student;

    public function init()
    {
        $this->sql = Queries::enrollment($this->student->StudentId, $this->student->CurrentMajor);
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
                'hAlign' => GridView::ALIGN_CENTER,
                'vAlign' => GridView::ALIGN_MIDDLE,
                'group' => true,
                'value' => function ($model) {
                    if (isset(\Yii::$app->params['yearSelector'][$model['StudyPlanYear']])) {
                        return \Yii::$app->params['yearSelector'][$model['StudyPlanYear']] . ' Year';
                    } else {
                        return $model['StudyPlanYear'];
                    }
                },
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
            ],
            [
                'label' => 'Season',
                'class' => DataColumn::className(),
                'attribute' => 'StudyPlanSeason',
                'hAlign' => GridView::ALIGN_CENTER,
                'vAlign' => GridView::ALIGN_MIDDLE,
                'group' => true,
                'subGroupOf' => 0,
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
            ],
            [
                'label' => 'Suggested Course',
                'class' => DataColumn::className(),
                'attribute' => 'CourseLetter',
            ],
            [
                'label' => 'Enrolled Course',
                'class' => EditableColumn::className(),
                'attribute' => 'CourseName',
                'refreshGrid' => true,
                'readonly' => function ($model) {
                    return !$model['StudyPlanId'];
                },
                'editableOptions' => function ($model, $key, $index, $column) {
                    return [
                        'beforeInput' => function ($form, $widget) {
                            echo Html::hiddenInput('StudyPlanId', $widget->model['StudyPlanId']);
                            echo Html::hiddenInput('StudentId', $widget->model['StudentId']);
                        },
                        'name' => 'OfferedCourseId',
                        'header' => 'Course Enrollment',
                        'inputType' => Editable::INPUT_SELECT2,
                        'formOptions' => [
                            'method' => 'post',
                            'action' => ['enrollment/register-course']
                        ],
                        'options' => [
                            'options' => [
                                'prompt' => 'Select Course',
                            ],
                            'data' => Cached::offeredCourseSelector($model['CourseLetter'])
                        ]
                    ];
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['enrollment/drop', 'id' => $model['StudentCourseEnrollmentId']]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-arrow-down pointer",
                            'title' => 'drop',
                            'onclick' => "gridControl.delete(this,'$url')",
                        ]);
                    },
                ]
            ]
        ];
    }

    public function search($params)
    {

    }

    public function searchModel($params = null)
    {
        return null;
    }
}