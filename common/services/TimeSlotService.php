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
use yii\web\HttpException;

class TimeSlotService
{
    /**
     * @param string $start is when doctor starts his reception
     * @param string $end is when doctor ends his reception
     * @return bool true if start is first in time
     */
    public function isStartBeforeEnd(string $start, string $end):bool
    {
        return strtotime($start) < strtotime($end);
    }

    /**
     * @param TimeSlot $timeSlot
     * @return bool true if there is confluence with a new timeslot
     */
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
            if ($identity->doctor == null) {
                return false;
            }
                if ($value != $identity->doctor->doctorId) {
                    return false;
                }
            return true;
        }
        throw new HttpException(401,'Unauthorized.');
    }
}
