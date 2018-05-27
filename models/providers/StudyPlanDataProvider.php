<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\Course;
use app\models\Department;
use app\models\Major;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use app\models\search\StudyPlanSearchModel;
use app\models\StudyPlan;
use kartik\grid\DataColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class StudyPlanDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;
    public $major;

    public function init()
    {
        parent::init();
        $this->query = StudyPlan::find()
            ->major($this->major)
            ->innerJoinWith('major', true)
            ->orderBy(['Year' => SORT_ASC, 'Season' => SORT_ASC])
            ->active();
        $this->sort->attributes['major'] = [
            'asc' => ['major.Name' => SORT_ASC],
            'desc' => ['major.Name' => SORT_DESC],
        ];
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'class' => DataColumn::className(),
                'attribute' => 'Year',
                'width' => '22.5%',
                'group' => true,
                'value' => function ($model) {
                    return \Yii::$app->params['yearSelector'][$model->Year] . ' Year';
                },
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Season',
                'width' => '22.5%',
                'group' => true,
                'subGroupOf' => 0,
                'groupOddCssClass' => 'kv-grouped-row',
                'groupEvenCssClass' => 'kv-grouped-row',
            ],
            [
                'label' => 'Course Number',
                'class' => DataColumn::className(),
                'attribute' => 'CourseLetter',
                'width' => '45%',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['study-plan/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['study-plan/delete', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-trash pointer",
                            'onclick' => "gridControl.delete(this,'$url')",
                        ]);
                    },
                ]
            ]
        ];
    }

    public function search($params)
    {
        $this->searchModel($params);
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new StudyPlanSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}