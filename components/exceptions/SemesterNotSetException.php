<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/1/2018
 * Time: 4:21 PM
 */

namespace app\components\exceptions;


use yii\helpers\Url;
use yii\web\HttpException;

class SemesterNotSetException extends HttpException
{
    public function __construct()
    {
        $url = Url::to(['term/index']);
        parent::__construct(400, "Semester not set, <a href='{$url}'><b>create one?</b></a>", 1000);
    }

}