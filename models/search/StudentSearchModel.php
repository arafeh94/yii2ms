<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Student;

class StudentSearchModel extends Student
{
    public $cycle;

    public function rules()
    {
        return [
            [['cycle', 'FirstName', 'LastName', 'FatherName'], 'safe']
        ];
    }
}