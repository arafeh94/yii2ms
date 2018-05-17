<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\OfferedCourse;

class OfferedCourseSearchModel extends OfferedCourse
{
    public $campus;
    public $instructor;
    public $course;

    public function rules()
    {
        return [
            [['CRN', 'Section', 'campus', 'instructor', 'course'], 'safe']
        ];
    }
}