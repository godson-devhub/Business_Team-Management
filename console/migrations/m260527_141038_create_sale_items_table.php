<?php

use yii\db\Migration;

class m260527_141038_create_sale_items_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions =
                'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sale_items}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // RELATIONSHIPS
            'sale_id' => $this->integer()->notNull(),

            'product_id' => $this->integer()->notNull(),

            'branch_id' => $this->integer()->notNull(),

            'business_id' => $this->integer()->notNull(),

            // ITEM INFO
            'quantity' => $this->integer()->notNull(),

            'buying_price' => $this->decimal(10,2)->notNull(),

            'selling_price' => $this->decimal(10,2)->notNull(),

            // CALCULATIONS
            'subtotal' => $this->decimal(12,2)->notNull(),

            'profit' => $this->decimal(12,2)->notNull(),

            // AUDIT
            'created_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-sale_items-sale_id', '{{%sale_items}}', 'sale_id');
        $this->createIndex('idx-sale_items-product_id', '{{%sale_items}}', 'product_id');
        $this->createIndex('idx-sale_items-branch_id', '{{%sale_items}}', 'branch_id');
        $this->createIndex('idx-sale_items-business_id', '{{%sale_items}}', 'business_id');

        // FOREIGN KEYS

        $this->addForeignKey(
            'fk-sale_items-sale_id',
            '{{%sale_items}}',
            'sale_id',
            '{{%sale}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sale_items-product_id',
            '{{%sale_items}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sale_items-branch_id',
            '{{%sale_items}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sale_items-business_id',
            '{{%sale_items}}',
            'business_id',
            '{{%business}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-sale_items-business_id', '{{%sale_items}}');
        $this->dropForeignKey('fk-sale_items-branch_id', '{{%sale_items}}');
        $this->dropForeignKey('fk-sale_items-product_id', '{{%sale_items}}');
        $this->dropForeignKey('fk-sale_items-sale_id', '{{%sale_items}}');

        $this->dropTable('{{%sale_items}}');
    }
}