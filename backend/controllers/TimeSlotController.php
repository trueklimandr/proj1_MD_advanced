<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 15.03.18
 * Time: 10:14
 */

namespace backend\controllers;

use common\models\TimeSlot;

class TimeSlotController extends RestController
{
    public $modelClass = TimeSlot::class;
}
