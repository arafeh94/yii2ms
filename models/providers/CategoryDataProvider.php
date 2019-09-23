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
use app\models\Customer;
use app\models\Department;
use app\models\Employee;
use app\models\Major;
use app\models\Project;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use phpDocumentor\Reflection\Types\Boolean;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CategoryDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = Category::find();
    }

    /**
     * @return array
     */
    function columns()
    {
        return [['attribute' => 'name', 'as' => 'editable']];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['name'];
    }
}