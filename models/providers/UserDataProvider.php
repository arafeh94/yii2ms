<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\User;
use kartik\grid\DataColumn;
use Mpdf\Tag\U;
use yii\base\Model;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class UserDataProvider extends ActiveDataProvider implements GridConfig
{
    /** @var $searchModel Model */
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = User::find()->active();
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
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
                'attribute' => 'Username'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Email'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['user/view', 'id' => $model->UserId]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['user/delete', 'id' => $model->UserId]);
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
            $this->searchModel = new User();
        }

        if ($params) {
            $this->searchModel->load($params,'');
        }

        return $this->searchModel;

    }
}