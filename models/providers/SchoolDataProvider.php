<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\School;
use kartik\grid\DataColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class SchoolDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = School::find()->active();
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'class' => DataColumn::className(),
                'attribute' => 'Name'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['school/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['school/delete', 'id' => $model->SchoolId]);
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
            $this->query->andFilterWhere(['like', "lower({$key})", strtolower($value)]);
        }
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new School();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}