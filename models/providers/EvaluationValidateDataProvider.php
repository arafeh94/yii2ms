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
use app\models\InstructorEvaluationEmail;
use app\models\Major;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class EvaluationValidateDataProvider extends ActiveDataProvider implements GridConfig
{
    public $searchModel;
    public $evaluationEmailId;

    public function init()
    {
        parent::init();
        $this->query = InstructorEvaluationEmail::find()->active()->innerJoinWith('instructor')->where(['EvaluationEmailId' => $this->evaluationEmailId]);
    }

    /**
     * @return array
     */
    public function gridColumns()
    {
        return [
            [
                'label' => 'Instructor',
                'class' => DataColumn::className(),
                'attribute' => 'instructor',
                'value' => function ($model) {
                    return $model->instructor->fullName;
                }
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'DateFilled',
            ],
            [
                'class' => BooleanColumn::className(),
                'attribute' => 'IsSent',
                'label' => 'Mail Sent',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {copy} {send}',
                'buttons' => [
                    'view' => function ($key, $model, $index) {
                        return Html::button('open', [
                            'class' => "btn btn-success",
                            'onclick' => "location.href='$model->url'",
                        ]);
                    },
                    'copy' => function ($key, $model, $index) {
                        return Html::button('copy', [
                            'class' => "btn btn-danger",
                            'onclick' => "copy('$model->url')",
                        ]);
                    },
                    'send' => function ($key, $model, $index) {
                        $url = Url::to(['evaluation/send', 'id' => $model->InstructorEvaluationEmailId]);
                        $ajax = "(function(){ $.ajax({type: 'POST', url: '$url', dataType: 'json', success: function (data) {data ? toastr.info('sent') : toastr.error('error');}});})()";
                        return Html::button('resend', [
                            'encode' => false,
                            'class' => "btn btn-info",
                            'onclick' => $ajax,
                        ]);
                    },
                ]
            ]
        ];
    }

    public function search($params)
    {
        $this->searchModel($params);
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