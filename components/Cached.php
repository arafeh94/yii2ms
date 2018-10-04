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
    public static function offeredCourseSelector($suggested = null, $flush = true)
    {
        if ($flush) \Yii::$app->cache->delete('courses');
        $data = \Yii::$app->cache->getOrSet('courses', function () {
            return \Yii::$app->db->createCommand(Queries::offeredCourses())->queryAll();
        });
        $options = ArrayHelper::map($data, 'OfferedCourseId', function ($item) {
            return $item['Section'] . ' - ' . $item['Letter'];
        });
        if ($suggested) {
            $suggested = explode('/', str_replace('-', '.', $suggested));
            $filtered = array_filter($data, function ($item) use ($suggested) {
                foreach ($suggested as $sug) {
                    if (preg_match("/$sug/", $item['Major'] . ':' . $item['Letter'])) return true;

                }
                return false;
            });
            if ($filtered) {
                $filtered = ArrayHelper::map($filtered, 'OfferedCourseId', function ($item) {
                    return $item['Section'] . ' - ' . $item['Letter'];
                });
                $options = ['Suggested' => $filtered, 'Courses' => $options];
            }
        }

        return $options;
    }
}