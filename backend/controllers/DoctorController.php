<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 28.02.18
 * Time: 14:21
 */
namespace backend\controllers;

use common\models\Doctor;

class DoctorController extends RestController
{
    public $modelClass = Doctor::class;
}
