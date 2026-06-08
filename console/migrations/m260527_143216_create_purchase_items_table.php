<?php

use yii\db\Migration;

class m260527_143216_create_purchase_items_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions =
                'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%purchase_items}}', [

            // PRIMARY KEY
            'id' => $this->primaryKey(),

            // RELATIONS
            'purchase_id' => $this->integer()->notNull(),

            'product_id' => $this->integer()->notNull(),

            'business_id' => $this->integer()->notNull(),

            'branch_id' => $this->integer()->notNull(),

            // ITEM INFO
            'quantity' => $this->integer()->notNull(),

            'buying_price' => $this->decimal(10,2)->notNull(),

            // CALCULATION
            'subtotal' => $this->decimal(12,2)->notNull(),

            // STOCK CONTROL
            'is_posted_to_stock' => $this->boolean()->defaultValue(false),

            // AUDIT
            'created_at' => $this->integer()->notNull(),

        ], $tableOptions);

        // INDEXES
        $this->createIndex('idx-purchase_items-purchase_id', '{{%purchase_items}}', 'purchase_id');
        $this->createIndex('idx-purchase_items-product_id', '{{%purchase_items}}', 'product_id');
        $this->createIndex('idx-purchase_items-branch_id', '{{%purchase_items}}', 'branch_id');
        $this->createIndex('idx-purchase_items-business_id', '{{%purchase_items}}', 'business_id');

        // FOREIGN KEYS

        $this->addForeignKey(
            'fk-purchase_items-purchase_id',
            '{{%purchase_items}}',
            'purchase_id',
            '{{%purchase}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-purchase_items-product_id',
            '{{%purchase_items}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-purchase_items-branch_id',
            '{{%purchase_items}}',
            'branch_id',
            '{{%branch}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-purchase_items-business_id',
            '{{%purchase_items}}',
            'business_id',
            '{{%business}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-purchase_items-business_id', '{{%purchase_items}}');
        $this->dropForeignKey('fk-purchase_items-branch_id', '{{%purchase_items}}');
        $this->dropForeignKey('fk-purchase_items-product_id', '{{%purchase_items}}');
        $this->dropForeignKey('fk-purchase_items-purchase_id', '{{%purchase_items}}');

        $this->dropTable('{{%purchase_items}}');
    }
}