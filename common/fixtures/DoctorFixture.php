<?php
/**
 * Created by PhpStorm.
 * User: andersen
 * Date: 11.04.18
 * Time: 12:43
 */

namespace common\fixtures;

use common\models\Doctor;
use yii\test\ActiveFixture;

class DoctorFixture extends ActiveFixture
{
    public $modelClass = Doctor::class;
    public $depends = [UserFixture::class];
}
