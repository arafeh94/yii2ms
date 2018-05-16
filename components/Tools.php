<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use yii\base\Component;
use yii\db\Connection;
use yii\helpers\Json;

class Tools extends Component
{
    static function forcePrint($message)
    {
        $message = Json::encode($message);
        throw new \RuntimeException($message);
    }

    static function prettyPrint($message)
    {
        $message = Json::encode($message);
        echo "<pre>$message</pre>";
    }

    static function console($msg)
    {
        $msg = json_encode($msg);
        \Yii::$app->view->registerJs("console.log({$msg})");
    }

}