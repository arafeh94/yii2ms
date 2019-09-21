<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\models\providers;


use app\components\extensions\AppDataProvider;
use app\components\GridConfig;
use app\components\Tools;
use app\models\Category;
use app\models\Course;
use app\models\Department;
use app\models\Major;
use app\models\Project;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Boolean;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ProjectDataProvider extends AppDataProvider
{

    public function query()
    {
        $this->query = Project::find()
            ->innerJoinWith('customer')
            ->innerJoinWith('category');
    }

    public function columns()
    {
        return [
            ['attribute' => 'po_number',],
            ['attribute' => 'name',],
            ['attribute' => 'customer.name', 'label' => 'Customer'],
            ['attribute' => 'category.name', 'label' => 'Category'],
            ['attribute' => 'order_value',],
            ['attribute' => 'date_begin', 'include' => 'date'],
            ['attribute' => 'date_end', 'include' => 'date'],
        ];
    }


    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['po_number', 'name', 'order_value', 'customer.name', 'category.name', 'date_begin', 'date_end'];
    }


}