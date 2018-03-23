<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 15.03.18
 * Time: 10:14
 */

namespace backend\controllers;

use common\models\TimeSlot;
use common\services\ListSlotService;
use Yii;
use yii\base\Module;

class TimeSlotController extends RestController
{
    public $modelClass = TimeSlot::class;
    private $listSlotService;

    public function __construct(
        string $id,
        Module $module,
        ListSlotService $listSlotService,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->listSlotService = $listSlotService;
    }

    /**
     * @return array|null|\yii\db\ActiveRecord[] list of doctor's (specified in request header) slots
     */
    public function actionList()
    {
        $timeSlots = $this->listSlotService->getListOfSlots();
        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);
        return $timeSlots;
    }
}
