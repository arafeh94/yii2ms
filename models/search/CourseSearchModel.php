<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Course;

class CourseSearchModel extends Course
{
    public $major;

    public function rules()
    {
        return [
            [['Name', 'major', 'Credits', 'Letter', 'IsActivate'], 'safe']
        ];
    }
}