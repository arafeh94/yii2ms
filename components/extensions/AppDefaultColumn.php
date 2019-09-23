<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\components\extensions;


use app\components\GridConfig;
use app\components\Tools;
use app\models\Course;
use app\models\Department;
use app\models\Major;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\editable\Editable;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Boolean;
use yii\base\DynamicModel;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\db\QueryBuilder;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class AppDefaultColumn
{
    public static $columns = [
        'date' => [
            'format' => 'date',
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'format' => 'y-M-d',
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ],
        ],
        'editable' => [
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions' => [
                'inputType' => Editable::INPUT_TEXT,
            ],
        ],
        'checkbox' => [
            'class' => '\kartik\grid\CheckboxColumn',
        ]
    ];
}