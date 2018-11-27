<?php

use yii\db\Migration;

/**
 * Class m181127_144450_mail_is_sent
 */
class m181127_144450_mail_is_sent extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table = Yii::$app->db->schema->getTableSchema('instructorevaluationemail');
        if (!isset($table->columns['IsSent'])) {
            $this->addColumn('instructorevaluationemail','IsSent','bit(1) default 0');
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m181127_144450_mail_is_sent cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181127_144450_mail_is_sent cannot be reverted.\n";

        return false;
    }
    */
}
