<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 14.03.18
 * Time: 12:35
 */

namespace backend\tests\functional\baseCest;

use Yii;

class BaseFunctionalCest
{
    private $transaction;

    public function _before()
    {
        $this->transaction = Yii::$app->db->beginTransaction();
    }

    public function _after()
    {
        $this->transaction->rollback();
    }
}
