<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 23.03.18
 * Time: 15:18
 */

namespace common\models;

use common\services\RecordService;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Record for table record
 * Record describes the time that users reserves
 * @package common\models
 * @property int $id
 * @property int $userId
 * @property int $doctorId
 * @property string $date is a date of record
 * @property string $start is a start time of record
 * @property string $end is an end of record
 */
class Record extends ActiveRecord
{
    private $recordService;

    /**
     * connects a service for farther data verification
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function init()
    {
        parent::init();

        $this->recordService = Yii::$container->get(RecordService::class);
    }

    /**
     * @return array of rules of access to record table in DB
     */
    public function rules()
    {
        return [
            [['userId', 'doctorId', 'date', 'start', 'end'], 'safe'],
            [['userId', 'doctorId', 'date', 'start', 'end'], 'required'],
            ['date', 'validateDate'],
            ['start', 'validateRecord'],
            ['end', 'validateRecord'],
            ['userId', 'validateUser']
        ];
    }

    /**
     * this is "link" to foreign key in user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }

    /**
     * this is "link" to foreign key in doctor
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['doctorId' => 'doctorId']);
    }

    /**
     * Date must be not in the past
     * @param $attribute string with date must be a validating date
     * @param $params
     */
    public function validateDate($attribute, $params)
    {
        if (strtotime($this->$attribute) < strtotime('today')) {
            $this->addError($attribute, 'Use valid date. You can\'t take up in the past!!!');
        }
    }

    /**
     * Check right position of start and end of a record
     * @param $attribute string with start or end
     * @param $params
     */
    public function validateRecord($attribute, $params)
    {
        if (!$this->recordService->isStartBeforeEnd($this->start, $this->end)) {
            $this->addError($attribute, 'Start must be earlier than end.');
        }
        if ($this->recordService->isConfluence($this)) {
            $this->addError($attribute, 'Your record has confluence with existing one');
        }
        if (!$this->recordService->isSatisfiedTimeSlot($this)) {
            $this->addError($attribute, 'Your record not satisfies at least one timeslot');
        }
    }

    /**
     * Check userId for its owner and for its existence
     * @param $attribute
     * @param $params
     */
    public function validateUser($attribute, $params)
    {
        if (!$this->recordService->isValidUser($this->$attribute)) {
            $this->addError($attribute, 'You can create new record for yourself only.');
        }
    }
}
