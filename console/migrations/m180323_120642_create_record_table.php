<?php

use yii\db\Migration;

/**
 * Handles the creation of table `record`.
 */
class m180323_120642_create_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('record', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'doctorId' => $this->integer()->notNull(),
            'date' => $this->date(),
            'start' => $this->time(),
            'end' => $this->time()
        ]);

        $this->addForeignKey(
            'fkRecordUserId',
            'record',
            'userId',
            'user',
            'userId'
        );

        $this->addForeignKey(
            'fkRecordDoctorId',
            'record',
            'doctorId',
            'doctor',
            'doctorId'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('record');
    }
}
