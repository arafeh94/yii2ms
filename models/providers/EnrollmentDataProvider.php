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
use app\models\StudentCourseEnrollment;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class EnrollmentDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;
    public $student;

    public function init()
    {
        parent::init();
        $this->query = StudentCourseEnrollment::find()->innerJoinWith('offeredCourse')->innerJoinWith('studentSemesterEnrollment')->innerJoinWith('studentSemesterEnrollment.student')->where(['student.UniversityId' => $this->student])->innerJoinWith('offeredCourse.instructor')->innerJoinWith('offeredCourse.campus')->innerJoinWith('offeredCourse.course')->active();
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'class' => DataColumn::className(),
                'attribute' => 'campus',
                'label' => 'Campus',
                'value' => function ($model) {
                    return $model->offeredCourse->campus->Name;
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
                    return $model->offeredCourse->course->Name;
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
                    return $model->offeredCourse->instructor->Title . '. ' . $model->offeredCourse->instructor->FirstName . ' ' . $model->offeredCourse->instructor->LastName;
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
                'attribute' => 'offeredCourse.CRN',
                'width' => '100px'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'offeredCourse.Section',
                'width' => '100px'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{drop} {delete}',
                'buttons' => [
                    'drop' => function ($key, $model, $index) {
                        $url = Url::to(['offered-course/drop', 'id' => $model->OfferedCourseId]);
                        return Html::tag('span', '', [
                            'class' => "glyphicon glyphicon-arrow-down pointer",
                            'onclick' => "gridControl.drop(this,'$url')",
                        ]);
                    },
                    'delete' => function ($key, $model, $index) {
                        $url = Url::to(['enrollment/delete', 'id' => $model->StudentCourseEnrollmentId]);
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

    }

    public function searchModel($params = null)
    {
        return null;
    }
}