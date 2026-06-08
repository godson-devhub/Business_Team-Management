<?php

use yii\db\Migration;

class m260527_140854_create_sale_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions =
                'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sale}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // RELATIONS
            'branch_id' => $this->integer()->notNull(),

            'user_id' => $this->integer()->notNull(), // seller

            'business_id' => $this->integer()->notNull(),

            // MONEY
            'total_amount' => $this->decimal(12,2)->defaultValue(0),

            'total_profit' => $this->decimal(12,2)->defaultValue(0),

            // STATUS (ERP READY)
            'status' => "ENUM(
                'pending',
                'completed',
                'cancelled',
                'refunded'
            ) NOT NULL DEFAULT 'completed'",

            // TIMESTAMP (CONSISTENT)
            'created_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-sale-branch_id', '{{%sale}}', 'branch_id');
        $this->createIndex('idx-sale-user_id', '{{%sale}}', 'user_id');
        $this->createIndex('idx-sale-business_id', '{{%sale}}', 'business_id');

        // FOREIGN KEYS

        $this->addForeignKey(
            'fk-sale-branch_id',
            '{{%sale}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sale-user_id',
            '{{%sale}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sale-business_id',
            '{{%sale}}',
            'business_id',
            '{{%business}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-sale-business_id', '{{%sale}}');
        $this->dropForeignKey('fk-sale-user_id', '{{%sale}}');
        $this->dropForeignKey('fk-sale-branch_id', '{{%sale}}');

        $this->dropTable('{{%sale}}');
    }
}