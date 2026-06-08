<?php

use yii\db\Migration;

class m260527_134049_create_stock_movement_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // =========================
        // TABLE
        // =========================
        $this->createTable('{{%stock_movement}}', [

            'id' => $this->primaryKey(),

            // RELATIONS
            'product_id' => $this->integer()->notNull(),
            'branch_id'  => $this->integer()->notNull(),
            'user_id'    => $this->integer()->notNull(),

            // TYPE
            'type' => "ENUM('IN','OUT','ADJUSTMENT') NOT NULL",

            // STOCK DATA
            'quantity' => $this->integer()->notNull(),
            'previous_stock' => $this->integer()->notNull(),
            'new_stock' => $this->integer()->notNull(),

            // NOTE
            'note' => $this->text()->null(),

            // TIME
            'created_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // =========================
        // INDEXES
        // =========================
        $this->createIndex(
            'idx-stock-movement-product',
            '{{%stock_movement}}',
            'product_id'
        );

        $this->createIndex(
            'idx-stock-movement-branch',
            '{{%stock_movement}}',
            'branch_id'
        );

        $this->createIndex(
            'idx-stock-movement-user',
            '{{%stock_movement}}',
            'user_id'
        );

        // =========================
        // FOREIGN KEYS (SAFE NAMES)
        // =========================

        $this->addForeignKey(
            'fk_stock_movement_product',
            '{{%stock_movement}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_stock_movement_branch',
            '{{%stock_movement}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_stock_movement_user',
            '{{%stock_movement}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_stock_movement_user', '{{%stock_movement}}');
        $this->dropForeignKey('fk_stock_movement_branch', '{{%stock_movement}}');
        $this->dropForeignKey('fk_stock_movement_product', '{{%stock_movement}}');

        $this->dropTable('{{%stock_movement}}');
    }
}