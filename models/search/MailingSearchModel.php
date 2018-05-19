<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\Major;

class MailingSearchModel extends Major
{
    public $semester;

    public function rules()
    {
        return [
            [['semester', 'Quarter'], 'safe']
        ];
    }
}