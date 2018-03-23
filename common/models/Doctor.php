<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 28.02.18
 * Time: 11:45
 */
namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Doctor for table doctor
 * @package common\models
 * @property int $doctorId
 * @property int $userId
 * @property string $specialization
 */

class Doctor extends ActiveRecord
{
    public function rules()
    {
        return [
            [['specialization', 'userId'], 'safe'],
            [['specialization', 'userId'], 'required'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }

    public function getTimeSlots()
    {
        return $this->hasMany(TimeSlot::class, ['doctorId' => 'doctorId']);
    }
}
