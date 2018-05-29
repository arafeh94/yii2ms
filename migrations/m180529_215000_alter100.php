<?php

use app\components\SQLFileExecutor;
use yii\db\Migration;

/**
 * Class m180529_215000_alter100
 */
class m180529_215000_alter100 extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $path = __DIR__ . '/assets/alter100.sql';
        echo SQLFileExecutor::execute($path);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $path = __DIR__ . '/assets/_alter100.sql';
        echo SQLFileExecutor::execute($path);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180529_215000_alter100 cannot be reverted.\n";

        return false;
    }
    */
}
