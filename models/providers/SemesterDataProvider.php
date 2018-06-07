<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\Department;
use app\models\search\DepartmentSearchModel;
use app\models\search\SemesterSearchModel;
use app\models\Season;
use app\models\Semester;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\CheckboxColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class SemesterDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = Semester::find()->active();
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
                'width' => '80px',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Season',
                'label' => 'Season',
                'width' => '120px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['Spring' => 'Spring', 'Fall' => 'Fall', 'Summer' => 'Summer'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'StartDate',
                'format' => 'date',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => \Yii::$app->params['dateFormat'],
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'EndDate',
                'format' => 'date',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => \Yii::$app->params['dateFormat'],
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
            ],
            [
                'class' => BooleanColumn::className(),
                'attribute' => 'IsCurrent',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['term/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['term/delete', 'id' => $model->SemesterId]);
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
        $this->query->andFilterWhere(['like', 'semester.Season', ArrayHelper::getValue($params, 'Season', '')]);
        $this->query->andFilterWhere(['like', 'semester.Year', ArrayHelper::getValue($params, 'Year', '')]);
        $this->query->andFilterWhere(['like', 'semester.StartDate', ArrayHelper::getValue($params, 'StartDate', '')]);
        $this->query->andFilterWhere(['like', 'semester.EndDate', ArrayHelper::getValue($params, 'EndDate', '')]);
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new SemesterSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}