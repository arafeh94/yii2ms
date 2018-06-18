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
use kartik\grid\DataColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CourseDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = Course::find()
            ->innerJoinWith('major')->active();
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
                'attribute' => 'major',
                'label' => 'Major',
                'value' => function ($model) {
                    return $model->major->Name;
                }
            ],
            [
                'label' => 'Title',
                'class' => DataColumn::className(),
                'attribute' => 'Name',
            ],
            [
                'label' => 'Course',
                'class' => DataColumn::className(),
                'attribute' => 'Letter',
            ],
            [
                'label' => 'Credits',
                'class' => DataColumn::className(),
                'attribute' => 'Credits',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['course/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['course/delete', 'id' => $model->MajorId]);
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
        $this->query->andFilterWhere(['like', 'lower(course.Name)', strtolower(ArrayHelper::getValue($params, 'Name', ''))]);
        $this->query->andFilterWhere(['like', 'lower(major.Name)', strtolower(ArrayHelper::getValue($params, 'major', ''))]);
        $this->query->andFilterWhere(['like', 'Letter', ArrayHelper::getValue($params, 'Letter', '')]);
        $this->query->andFilterWhere(['like', 'Credits', ArrayHelper::getValue($params, 'Credits', '')]);
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new CourseSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}