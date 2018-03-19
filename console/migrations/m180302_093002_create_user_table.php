<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180302_093002_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'userId' => $this->primaryKey(),
            'firstName' => $this->string(255),
            'lastName' => $this->string(255),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'type' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
