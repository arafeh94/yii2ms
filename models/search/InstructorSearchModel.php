<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Instructor;

class InstructorSearchModel extends Instructor
{

    public function rules()
    {
        return [
            [['UniversityId', 'FirstName', 'LastName', 'Email', 'PhoneExtension', 'Title'], 'safe']
        ];
    }
}