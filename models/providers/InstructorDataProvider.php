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
use app\models\Instructor;
use app\models\search\DepartmentSearchModel;
use app\models\search\InstructorSearchModel;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use Yii;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class InstructorDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = Instructor::find()->active();
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'class' => DataColumn::className(),
                'attribute' => 'UniversityId',
                'width' => '115px'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Title',
                'width' => '100px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => Yii::$app->params['titlesSelector'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'FirstName',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'LastName',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Email',
            ],
            [
                'label' => 'Ext.',
                'width' => '80px',
                'class' => DataColumn::className(),
                'attribute' => 'PhoneExtension',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'DateAdded',
                'format' => 'date',
                'width' => '105px',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['instructor/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['instructor/delete', 'id' => $model->InstructorId]);
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
        foreach ($params as $key => $value) {
            $this->query->andFilterWhere(['like', $key, $value]);
        }
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new InstructorSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}