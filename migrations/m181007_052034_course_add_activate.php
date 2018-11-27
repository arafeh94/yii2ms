<?php

use yii\db\Migration;

/**
 * Class m181007_052034_course_add_activate
 */
class m181007_052034_course_add_activate extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table = Yii::$app->db->schema->getTableSchema('course');
        if (!isset($table->columns['IsActivate'])) {
            $this->addColumn('course','IsActivate','bit(1) default 1');
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m181007_052034_course_add_activate cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181007_052034_course_add_activate cannot be reverted.\n";

        return false;
    }
    */
}
