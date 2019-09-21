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
use app\models\Project;
use app\models\ProjectPayment;
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

class ProjectPaymentDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = ProjectPayment::find();
    }

    /**
     * @return array
     */
    function columns()
    {
        return [
            ['attribute' => 'project.po_number'],
            ['attribute' => 'project.name'],
            ['attribute' => 'method'],
            ['attribute' => 'amount'],
            ['attribute' => 'CRVRef'],
            ['attribute' => 'date_due', 'include' => 'date'],
            ['attribute' => 'date_payment', 'include' => 'date']
        ];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.po_number', 'method', 'amount', 'CRVRef', 'date_due', 'date_payment'];
    }
}