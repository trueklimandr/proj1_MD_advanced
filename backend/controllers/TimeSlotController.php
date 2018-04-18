<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 15.03.18
 * Time: 10:14
 */

namespace backend\controllers;

use common\models\TimeSlot;
use common\services\TimeSlotService;
use Yii;
use yii\base\Module;

class TimeSlotController extends RestController
{
    public $modelClass = TimeSlot::class;

    /** @var TimeSlotService $timeSlotService */
    private $timeSlotService;

    public function __construct(
        string $id,
        Module $module,
        TimeSlotService $timeSlotService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->timeSlotService = $timeSlotService;
    }

    /**
     * @return TimeSlot[] list of doctor's (specified in request header) slots
     */
    public function actionList()
    {
        $doctorId = Yii::$app->request->headers['doctorId'];
        $timeSlots = $this->timeSlotService->getListOfSlots(is_numeric($doctorId) ? $doctorId : false);
        return $timeSlots;
    }
}
