<?php

use yii\db\Migration;

/**
 * Handles the creation of table `timeSlot`.
 */
class m180314_144625_create_timeSlot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('timeSlot', [
            'id' => $this->primaryKey(),
            'doctorId' => $this->integer()->notNull(),
            'date' => $this->date(),
            'start' => $this->time(),
            'end' => $this->time()
        ]);

        $this->addForeignKey(
            'fkTimeSlotDoctorId',
            'timeSlot',
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
        $this->dropTable('timeSlot');
    }
}
