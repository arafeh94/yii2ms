<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Major;

class MajorSearchModel extends Major
{
    public $department;

    public function rules()
    {
        return [
            [['Name', 'department'], 'safe']
        ];
    }
}