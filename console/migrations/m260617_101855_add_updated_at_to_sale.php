<?php

use yii\db\Migration;

class m260617_101855_add_updated_at_to_sale extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()

    {
        $table = '{{%sale}}';
        $column = $this->db->getTableSchema($table)->getColumn('updated_at');
        if ($column === null) {
            $this->addColumn($table, 'updated_at', $this->integer()->notNull());
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale}}', 'updated_at');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260617_101855_add_updated_at_to_sale cannot be reverted.\n";

        return false;
    }
    */
}
