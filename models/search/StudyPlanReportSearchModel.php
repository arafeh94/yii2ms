<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\EvaluationEmail;
use yii\base\Model;

class StudyPlanReportSearchModel extends EvaluationEmail
{
    public function rules()
    {
        return [
            [[], 'safe']
        ];
    }
}