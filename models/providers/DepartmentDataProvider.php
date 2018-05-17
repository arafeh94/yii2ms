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
use kartik\grid\DataColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class DepartmentDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = Department::find()->innerJoinWith('school')->active();
        $this->sort->attributes['school'] = [
            'asc' => ['school.Name' => SORT_ASC],
            'desc' => ['school.Name' => SORT_DESC],
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
                'attribute' => 'DepartmentId'
            ],
            [
                'label' => 'Department Name',
                'class' => DataColumn::className(),
                'attribute' => 'Name',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'school',
                'label' => 'School Name',
                'value' => function ($model) {
                    return $model->school->Name;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['department/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['department/delete', 'id' => $model->DepartmentId]);
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
            $this->searchModel = new DepartmentSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}