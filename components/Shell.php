<?php

namespace app\components;

use app\components\Tools;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Shell extends Component
{
    /**
     * take input only yii command
     * like migrate/create ...
     * @param $command
     */
    static function yii($command)
    {
        $cr = new ConsoleRunner(['file' => '@app/yii']);
        $cr->run($command);
    }
}
