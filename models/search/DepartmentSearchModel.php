<?php

namespace app\models\search;

use app\models\Department;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 3:09 AM
 */
class DepartmentSearchModel extends Department
{
    public $school;

    public function rules()
    {
        return [
            [['school', 'Name'], 'safe']
        ];
    }

}