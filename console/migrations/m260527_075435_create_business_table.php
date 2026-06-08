<?php

use yii\db\Migration;

class m260527_075435_create_business_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%business}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // OWNER RELATIONSHIP
            'owner_id' => $this->integer()->notNull(),

            // BUSINESS INFO
            'name' => $this->string()->notNull(),

            'description' => $this->text()->null(),

            'logo' => $this->string()->null(),

            'email' => $this->string()->null(),

            'phone' => $this->string(20)->null(),

            'address' => $this->string()->null(),

            // STATUS (ERP READY)
            'status' => $this->smallInteger()->notNull()->defaultValue(1),

            // TIMESTAMPS
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-business-owner_id', '{{%business}}', 'owner_id');

        // FOREIGN KEY
        $this->addForeignKey(
            'fk-business-owner_id',
            '{{%business}}',
            'owner_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-business-owner_id', '{{%business}}');
        $this->dropTable('{{%business}}');
    }
}