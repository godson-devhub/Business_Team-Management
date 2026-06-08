<?php

use yii\db\Migration;

class m260527_143109_create_purchase_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions =
                'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%purchase}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // RELATIONS
            'business_id' => $this->integer()->notNull(),

            'branch_id' => $this->integer()->notNull(),

            'user_id' => $this->integer()->notNull(), // seller/admin

            // SUPPLIER INFO
            'supplier_name' => $this->string()->null(),

            'supplier_contact' => $this->string(20)->null(),

            // MONEY
            'total_amount' => $this->decimal(12,2)->defaultValue(0),

            // STATUS (ERP READY)
            'status' => "ENUM(
                'pending',
                'completed',
                'received',
                'cancelled'
            ) NOT NULL DEFAULT 'pending'",

            // TIMESTAMP
            'created_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-purchase-business_id', '{{%purchase}}', 'business_id');
        $this->createIndex('idx-purchase-branch_id', '{{%purchase}}', 'branch_id');
        $this->createIndex('idx-purchase-user_id', '{{%purchase}}', 'user_id');

        // FOREIGN KEYS

        $this->addForeignKey(
            'fk-purchase-business_id',
            '{{%purchase}}',
            'business_id',
            '{{%business}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-purchase-branch_id',
            '{{%purchase}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-purchase-user_id',
            '{{%purchase}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-purchase-user_id', '{{%purchase}}');
        $this->dropForeignKey('fk-purchase-branch_id', '{{%purchase}}');
        $this->dropForeignKey('fk-purchase-business_id', '{{%purchase}}');

        $this->dropTable('{{%purchase}}');
    }
}