<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 03.04.18
 * Time: 10:15
 */

namespace common\services;

use common\models\Record;
use common\models\TimeSlot;
use Yii;
use yii\web\HttpException;

class RecordService
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
     * @param Record $record
     * @return bool true if there is confluence with a new record
     */
    public function isConfluence(Record $record):bool
    {
        $records = Record::find()->where(['doctorId' => $record->doctorId, 'date' => $record->date])->all();
        foreach ($records as $item) {
            if (!(strtotime($record->start) < strtotime($item['start']) &&
                    strtotime($record->end) <= strtotime($item['start'])) &&
                !(strtotime($record->start) >= strtotime($item['end']))) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Record $record
     * @return bool true if a new record satisfies at least one timeslot
     */
    public function isSatisfiedTimeSlot(Record $record):bool
    {
        $timeSlots = TimeSlot::find()->where(['doctorId' => $record->doctorId, 'date' => $record->date])->all();
        foreach ($timeSlots as $item) {
            if (!(strtotime($record->start) >= strtotime($item->start) &&
                strtotime($record->end) <= strtotime($item->end))) {
                return false;
            }
        }
        return $timeSlots !== [];
    }

    /**
     * @param $value - value of user attribute
     * @return bool
     * @throws HttpException
     */
    public function isValidUser($value):bool
    {
        $identity = Yii::$app->user->identity;
        if ($identity != null) {
            if ($value != $identity->userId) {
                return false;
            }
            return true;
        }
        throw new HttpException(401,'Unauthorized.');
    }
}
