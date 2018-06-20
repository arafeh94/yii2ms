<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\SQLFileExecutor;
use yii\console\Controller;

/**
 * This command to control sql from terminal.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SqlController extends Controller
{
    /**
     * This command clear and re-initialise database
     */
    public function actionFresh()
    {
        $path = __DIR__ . '/../migrations/assets/usp.sql';
        SQLFileExecutor::execute($path);
        \Yii::$app->cache->flush();
    }
}
