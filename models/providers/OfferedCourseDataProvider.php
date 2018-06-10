<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\GridConfig;
use app\models\Campus;
use app\models\Course;
use app\models\Department;
use app\models\Instructor;
use app\models\Major;
use app\models\OfferedCourse;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use app\models\search\OfferedCourseSearchModel;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class OfferedCourseDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->query = OfferedCourse::find()
            ->innerJoinWith('course')
            ->innerJoinWith('semester')
            ->innerJoinWith('instructor')
            ->innerJoinWith('campus')
            ->active();

        $this->sort->attributes['course'] = [
            'asc' => ['course.Name' => SORT_ASC],
            'desc' => ['course.Name' => SORT_DESC],
        ];
        $this->sort->attributes['instructor'] = [
            'asc' => ['instructor.FirstName' => SORT_ASC],
            'desc' => ['instructor.FirstName' => SORT_DESC],
        ];
        $this->sort->attributes['campus'] = [
            'asc' => ['campus.Name' => SORT_ASC],
            'desc' => ['campus.Name' => SORT_DESC],
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
                'label' => 'Semester',
                'value' => function ($model) {
                    return $model->semester->Season . ' - ' . $model->semester->Year;
                }
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'campus',
                'label' => 'Campus',
                'value' => function ($model) {
                    return $model->campus->Name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Campus::find()->orderBy('Name')->active()->all(), 'Name', 'Name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'course',
                'label' => 'Course',
                'value' => function ($model) {
                    return $model->course->Name;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Course::find()->orderBy('Name')->active()->all(), 'Name', 'Name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'instructor',
                'label' => 'Instructor',
                'value' => function ($model) {
                    return $model->instructor->FirstName . ' ' . $model->instructor->LastName;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(Instructor::find()->orderBy('FirstName')->active()->all(), function ($model) {
                    return $model->FirstName . ' ' . $model->LastName;
                }, function ($model) {
                    return $model->FirstName . ' ' . $model->LastName;
                }),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'CRN',
                'width' => '100px',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'Section',
                'width' => '100px'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($key, $model, $index) {
                        $url = Url::to(['offered-course/view', 'id' => $model->getPrimaryKey()]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-pencil pointer",
                            'onclick' => "modalForm(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['offered-course/delete', 'id' => $model->OfferedCourseId]);
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
        $this->query->andFilterWhere(['like', "concat(instructor.FirstName,' ',instructor.LastName)", ArrayHelper::getValue($params, 'instructor', '')]);
        $this->query->andFilterWhere(['like', 'course.Name', ArrayHelper::getValue($params, 'course', '')]);
        $this->query->andFilterWhere(['like', 'campus.Name', ArrayHelper::getValue($params, 'campus', '')]);
        $this->query->andFilterWhere(['like', 'CRN', ArrayHelper::getValue($params, 'CRN', '')]);
        $this->query->andFilterWhere(['like', 'Section', ArrayHelper::getValue($params, 'Section', '')]);
    }

    public function searchModel($params = null)
    {
        if ($this->searchModel === null) {
            $this->searchModel = new OfferedCourseSearchModel();
        }

        if ($params) {
            $this->searchModel->load($params, '');
        }

        return $this->searchModel;

    }
}