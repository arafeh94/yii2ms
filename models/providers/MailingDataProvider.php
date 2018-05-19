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
use app\models\EvaluationEmail;
use app\models\Major;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class MailingDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = EvaluationEmail::find()
            ->innerJoinWith('semester')
            ->active();
        $this->sort->attributes['semester'] = [
            'asc' => ['semester.Year' => SORT_ASC],
            'desc' => ['semester.Year' => SORT_DESC],
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
                'attribute' => 'semester',
                'label' => 'Semester Name',
                'value' => function ($model) {
                    return $model->semester->season->Name . ' - ' . $model->semester->Year;
                },
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Description',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Date',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Quarter',
            ],
            [
                'class' => BooleanColumn::className(),
                'attribute' => 'AvailableForInstructors',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['mailing/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['mailing/delete', 'id' => $model->EvaluationEmailId]);
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
        //todo fill the search model
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new MajorSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}