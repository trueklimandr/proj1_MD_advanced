<?php
/**
 * Created by PhpStorm.
 * User: andersen
 * Date: 11.04.18
 * Time: 12:57
 */

namespace common\fixtures;

use common\models\TimeSlot;
use yii\test\ActiveFixture;

class TimeSlotFixture extends ActiveFixture
{
    public $modelClass = TimeSlot::class;
    public $depends = [DoctorFixture::class];
}
