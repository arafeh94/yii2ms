<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Course;
use app\models\StudyPlan;

class StudyPlanSearchModel extends StudyPlan
{
    public $major;

    public function rules()
    {
        return [
            [[], 'safe']
        ];
    }
}