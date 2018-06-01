<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\Cycle;
use app\models\search\StudentSearchModel;
use app\models\Student;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class StudentDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = Student::find()->joinWith('cycle')->active();
        $this->sort->attributes['cycle'] = [
            'asc' => ['cycle.Name' => SORT_ASC],
            'desc' => ['cycle.Name' => SORT_DESC],
        ];
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'label' => 'Cycle',
                'class' => DataColumn::className(),
                'attribute' => 'cycle',
                'value' => function ($model) {
                    return $model->cycle->Name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Cycle::find()->orderBy('Name')->active()->all(), 'Name', 'Name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'FirstName'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'LastName'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'FatherName'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{enroll} {study-plan} {update} {delete}',
                'buttons' => [
                    'enroll' => function ($key, $model, $index) {
                        $url = Url::to(['enrollment/index', 'student' => $model->UniversityId]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-user pointer",
                            'onclick' => "location.href='$url'",
                        ]);
                    },
                    'study-plan' => function ($key, $model, $index) {
                        $url = Url::to(['study-plan/report', 'student' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-book pointer",
                            'onclick' => "location.href='$url'",
                        ]);
                    },
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['student/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['student/delete', 'id' => $model->StudentId]);
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
        if (isset($params['cycle'])) {
            $this->query->andFilterWhere(['like', 'cycle.Name', $params['cycle']]);
            unset($params['cycle']);
        }
        foreach ($params as $key => $value) {
            $this->query->andFilterWhere(['like', "lower({$key})", strtolower($value)]);
        }
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new StudentSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}