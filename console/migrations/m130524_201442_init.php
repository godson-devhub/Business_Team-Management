<?php

declare(strict_types=1);

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp(): void
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci 
            ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [

            // =========================
            // PRIMARY KEY
            // =========================
            'id' => $this->primaryKey(),

            // =========================
            // AUTH BASIC INFO
            // =========================
            'username' => $this->string()->notNull()->unique(),

            'email' => $this->string()->notNull()->unique(),

            'phone' => $this->string(20)->unique(),

            'password_hash' => $this->string()->notNull(),

            'auth_key' => $this->string(32)->notNull(),

            'password_reset_token' => $this->string()->unique(),

            'verification_token' => $this->string()->unique(),

            // =========================
            // ROLE SYSTEM
            // =========================
            'role' => "ENUM('owner','seller') NOT NULL DEFAULT 'seller'",

            // =========================
            // SELLER → BRANCH RELATION
            // =========================
            'branch_id' => $this->integer()->null(),

            // =========================
            // STATUS
            // =========================
            'status' => $this->smallInteger()
                ->notNull()
                ->defaultValue(10),

            // =========================
            // PROFILE (UI/UX)
            // =========================
            'profile_image' => $this->string()->null(),

            // =========================
            // LOGIN TRACKING
            // =========================
            'last_login_at' => $this->timestamp()->null(),

            // =========================
            // TIMESTAMPS
            // =========================
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // =========================
        // INDEXES (IMPORTANT FOR PERFORMANCE)
        // =========================
        $this->createIndex('idx-user-role', '{{%user}}', 'role');
        $this->createIndex('idx-user-branch', '{{%user}}', 'branch_id');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%user}}');
    }
}