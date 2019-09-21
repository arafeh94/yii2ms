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
use app\models\Invoice;
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

class InvoiceDataProvider extends AppDataProvider
{

    /**
     * @return void
     */
    function query()
    {
        $this->query = Invoice::find()->innerJoinWith('project');
    }

    /**
     * @return array
     */
    function columns()
    {
        return ['project.po_number', 'code', 'ref', 'quantity', 'price', 'inv_ref'];
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
     * @return array
     */
    function searchFields()
    {
        return ['project.po_number', 'code', 'ref', 'quantity', 'price', 'inv_ref'];
    }
}