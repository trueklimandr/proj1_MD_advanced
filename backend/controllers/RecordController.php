<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 23.03.18
 * Time: 15:40
 */

namespace backend\controllers;

use common\models\Record;

class RecordController extends RestController
{
    public $modelClass = Record::class;
}
