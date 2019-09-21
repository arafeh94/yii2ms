<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use app\models\Major;
use app\models\OfferedCourse;
use Symfony\Component\Finder\Glob;
use yii\base\Component;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Cached extends Component
{

    public static function put($key, $value)
    {
        \Yii::$app->cache->set($key, $value);
    }

    public static function get($key, $def)
    {
        $val = \Yii::$app->cache->get($key);
        return $val == false ? $def : $val;
    }

}