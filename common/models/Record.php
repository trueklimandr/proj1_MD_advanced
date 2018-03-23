<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 23.03.18
 * Time: 15:18
 */

namespace common\models;

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
    /**
     * @return array of rules of access to record table in DB
     */
    public function rules()
    {
        return [
            [['userId', 'doctorId', 'date', 'start', 'end'], 'safe'],
            [['userId', 'doctorId', 'date', 'start', 'end'], 'required'],
//            ['date', 'validateDate'],
//            ['start', 'validateSlot'],
//            ['end', 'validateSlot'],
//            ['doctorId', 'validateDoctor']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['doctorId' => 'doctorId']);
    }
}
