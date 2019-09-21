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
use app\models\Course;
use app\models\Customer;
use app\models\Department;
use app\models\Major;
use app\models\Procurement;
use app\models\Project;
use app\models\ProjectExpense;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use app\models\Supplier;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Boolean;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ProjectExpenseDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = ProjectExpense::find()
            ->innerJoinWith('employee')
            ->innerJoinWith('project');
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'project.po_number'],
            ['attribute' => 'project.name'],
            ['attribute' => 'employee.name'],
            ['attribute' => 'order_ref'],
            ['attribute' => 'expense_code'],
            ['attribute' => 'order_amount'],
            ['attribute' => 'date_expense', 'include' => 'date'],
        ];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.po_number', 'project.name', 'employee.name', 'order_ref', 'expense_code', 'order_amount', 'date_expense'];
    }
}