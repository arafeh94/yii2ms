<?php

use app\components\SQLFileExecutor;
use yii\db\Migration;

/**
 * Class m180515_171826_create_database
 */
class m180515_171826_create_database extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $path = __DIR__ . '/assets/usp.sql';
        echo SQLFileExecutor::execute($path);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180515_171826_create_database cannot be reverted.\n";
        return false;
    }


}
