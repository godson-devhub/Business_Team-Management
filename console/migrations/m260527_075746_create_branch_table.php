<?php

use yii\db\Migration;

class m260527_075746_create_branch_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%branch}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // BUSINESS RELATIONSHIP
            'business_id' => $this->integer()->notNull(),

            // BRANCH INFO
            'name' => $this->string()->notNull(),

            'location' => $this->string()->null(),

            'address' => $this->string()->null(),

            'phone' => $this->string(20)->null(),

            'email' => $this->string()->null(),

            // STATUS
            'status' => $this->smallInteger()->notNull()->defaultValue(1),

            // TIMESTAMPS (CONSISTENT WITH USER & BUSINESS)
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-branch-business_id', '{{%branch}}', 'business_id');

        // FOREIGN KEY
        $this->addForeignKey(
            'fk-branch-business_id',
            '{{%branch}}',
            'business_id',
            '{{%business}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-branch-business_id', '{{%branch}}');
        $this->dropTable('{{%branch}}');
    }
}