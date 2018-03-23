<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 23.03.18
 * Time: 8:45
 */

namespace common\services;

use common\models\TimeSlot;
use Yii;

class ListSlotService
{
    /**
     * @return bool|mixed "false" if there is no doctorId in headers
     */
    public function getDoctorIdFromRequest()
    {
        $doctorId = Yii::$app->request->headers['doctorId'];
        return is_numeric($doctorId) ? $doctorId : false;
    }

    /**
     * @return array|null|\yii\db\ActiveRecord[] "list of slots" if doctorId specified in request headers
     */
    public function getListOfSlots()
    {
        $doctorId = $this->getDoctorIdFromRequest();
        if ($doctorId) {
            return TimeSlot::find()
                ->where('doctorId='.$doctorId)
                ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
                ->all();
        }
        return array();
    }
}
