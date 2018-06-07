<?php

namespace app\models\search;

use app\models\Department;
use app\models\Semester;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 3:09 AM
 */
class SemesterSearchModel extends Semester
{

    public function rules()
    {
        return [
            [['Season', 'Year', 'StartDate', 'EndDate'], 'safe']
        ];
    }

}