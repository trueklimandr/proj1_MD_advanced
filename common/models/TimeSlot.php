<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 15.03.18
 * Time: 9:51
 */

namespace common\models;

use common\services\TimeSlotService;
use yii\db\ActiveRecord;
use yii;

/**
 * Class TimeSlot for table timeSlot
 * @package app\models
 * @property int $id
 * @property int $doctorId
 * @property string $date is a date of timeSlot
 * @property string $start is a start time of a timeSlot
 * @property string $end is an end of a timeSlot
 */
class TimeSlot extends ActiveRecord
{
    private $timeSlotService;

    public function init()
    {
        parent::init();

        $this->timeSlotService = Yii::$container->get(TimeSlotService::class);
    }

    public static function tableName()
    {
        return 'timeSlot';
    }

    /**
     * @return array of rules of access to timeSlot table in DB
     */
    public function rules()
    {
        return [
            [['doctorId', 'date', 'start', 'end'], 'safe'],
            [['doctorId', 'date', 'start', 'end'], 'required'],
            ['date', 'validateDate'],
            ['start', 'validateSlot'],
            ['doctorId', 'validateDoctor']
        ];
    }

    /**
     * this is "link" to foreign key in doctor
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['doctorId' => 'doctorId']);
    }

    public function validateDate($attribute, $params)
    {
        if (strtotime($this->$attribute) < strtotime('today')) {
            $this->addError($attribute, 'Use valid date. You can\'t take up in the past!!!');
        }
    }

    public function validateSlot($attribute, $params)
    {
        if (!$this->timeSlotService->isStartBeforeEnd($this->start, $this->end)) {
            $this->addError($attribute, 'Start must be earlier than end.');
        }
        if ($this->timeSlotService->isConfluence($this)) {
            $this->addError($attribute, 'Your slot has confluence with existing one');
        }
    }

    public function validateDoctor($attribute, $params)
    {
        if (!$this->timeSlotService->isValidDoctor($this->$attribute)) {
            $this->addError($attribute, 'You can create new slot for yourself only.');
        }
    }
}
