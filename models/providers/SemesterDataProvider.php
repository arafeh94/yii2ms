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
        $this->query = Semester::find()->innerJoinWith('season')->active();
        $this->sort->attributes['season'] = [
            'asc' => ['season.Name' => SORT_ASC],
            'desc' => ['season.Name' => SORT_DESC],
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
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'season',
                'label' => 'Season',
                'value' => function ($model) {
                    return $model->season->Name;
                }
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'StartDate',
                'format' => 'date',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'EndDate',
                'format' => 'date',
            ],
            [
                'class' => BooleanColumn::className(),
                'attribute' => 'IsCurrent',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'DateAdded',
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
        $this->query->andFilterWhere(['like', 'department.Name', ArrayHelper::getValue($params, 'Name', '')]);
        $this->query->andFilterWhere(['like', 'school.Name', ArrayHelper::getValue($params, 'school', '')]);
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