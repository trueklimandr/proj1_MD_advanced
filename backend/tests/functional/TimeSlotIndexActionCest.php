<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 22.03.18
 * Time: 17:55
 */

namespace backend\tests\functional;

use backend\tests\functional\baseCest\BaseFunctionalCest;
use backend\tests\FunctionalTester;
use common\models\AccessToken;
use common\models\Doctor;
use common\models\TimeSlot;
use Yii;

class TimeSlotIndexActionCest extends BaseFunctionalCest
{
    public function testGetListOfZeroSlots(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        $accessToken = $I->have(AccessToken::class);
        $I->amHttpAuthenticated($accessToken['token'], '');
        $I->sendGET('time-slots', ['doctorId' => $doctor->doctorId]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(0, count($response));
    }

    public function testGetListOfOneSlot(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        Yii::$app->user->identity = $doctor->user;
        $I->have(TimeSlot::class,['doctorId' => $doctor->doctorId]);
        $accessToken = $I->have(AccessToken::class,['userId' => $doctor->user->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->haveHttpHeader('doctorId', $doctor->doctorId);
        $I->sendGET('time-slots');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(1, count($response));
    }

    public function testGetListOfOneSlotWithIncorrectDoctorId(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        Yii::$app->user->identity = $doctor->user;
        $I->have(TimeSlot::class,['doctorId' => $doctor->doctorId]);
        $accessToken = $I->have(AccessToken::class,['userId' => $doctor->user->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->haveHttpHeader('doctorId', 'qwerty');
        $I->sendGET('time-slots');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(0, count($response));
    }
}
