<?php

use yii\db\Migration;

/**
 * Handles the creation of table `doctor`.
 */
class m180305_074957_create_doctor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('doctor', [
            'doctorId' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'specialization' => $this->string(255),
        ]);

        $this->addForeignKey(
            'fkDoctorUserId',
            'doctor',
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
        $this->dropTable('doctor');
    }
}
