<?php

use yii\db\Migration;

class m260527_091239_create_product_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // RELATIONS
            'branch_id' => $this->integer()->notNull(),

            'created_by' => $this->integer()->notNull(),

            // PRODUCT INFO
            'name' => $this->string()->notNull(),

            'sku' => $this->string()->unique(),

            'buying_price' => $this->decimal(10,2)->notNull(),

            'selling_price' => $this->decimal(10,2)->notNull(),

            'stock_quantity' => $this->integer()->defaultValue(0),

            'min_stock_alert' => $this->integer()->defaultValue(5),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),

            // TIMESTAMPS (CONSISTENT ERP STYLE)
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES (VERY IMPORTANT)
        $this->createIndex('idx-product-branch_id', '{{%product}}', 'branch_id');
        $this->createIndex('idx-product-created_by', '{{%product}}', 'created_by');

        // FK → branch
        $this->addForeignKey(
            'fk-product-branch_id',
            '{{%product}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE'
        );

        // FK → user (seller)
        $this->addForeignKey(
            'fk-product-created_by',
            '{{%product}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-product-created_by', '{{%product}}');
        $this->dropForeignKey('fk-product-branch_id', '{{%product}}');
        $this->dropTable('{{%product}}');
    }
}