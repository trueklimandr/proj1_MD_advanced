<?php

use yii\db\Migration;

/**
 * Handles the creation of table `accessToken`.
 */
class m180306_063053_create_accessToken_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('accessToken', [
            'token' => $this->string(255),
            'userId' => $this->integer()->notNull(),
            'PRIMARY KEY(token)',
        ]);

        $this->addForeignKey(
            'fkAccessTokenUserId',
            'accessToken',
            'userId',
            'user',
            'userId'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('accessToken');
    }
}
