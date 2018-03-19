<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 16.03.18
 * Time: 15:27
 */

namespace common\services;

use common\models\TimeSlot;
use Yii;
use common\models\Doctor;
use yii\web\HttpException;

class TimeSlotService
{
    public function isStartBeforeEnd(string $start, string $end):bool
    {
        return strtotime($start) < strtotime($end);
    }

    public function isConfluence(TimeSlot $timeSlot):bool
    {
        $timeSlots = TimeSlot::find()->where(['doctorId' => $timeSlot->doctorId, 'date' => $timeSlot->date])->all();
        foreach ($timeSlots as $item) {
            if (!(strtotime($timeSlot->start) < strtotime($item['start']) &&
                    strtotime($timeSlot->end) <= strtotime($item['start'])) &&
                !(strtotime($timeSlot->start) >= strtotime($item['end']))) {
            return true;
            }
        }
        return false;
    }

    /**
     * @param $value - value of doctor id attribute
     * @return bool
     * @throws HttpException
     */
    public function isValidDoctor($value):bool
    {
        $identity = Yii::$app->user->identity;
        if ($identity != null) {
            $doctor = Doctor::find()->where(['userId' => $identity->getId()])->one();
            if ($value != $doctor['doctorId']) {
                return false;
            }
            return true;
        }
        throw new HttpException(401,'Unauthorized.');
    }
}
