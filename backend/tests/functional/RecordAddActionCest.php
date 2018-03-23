<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 23.03.18
 * Time: 16:18
 */

namespace backend\tests\functional;


use backend\tests\functional\baseCest\BaseFunctionalCest;
use backend\tests\FunctionalTester;
use common\models\AccessToken;
use common\models\Doctor;
use common\models\TimeSlot;
use common\models\User;
use Yii;

class RecordAddActionCest extends BaseFunctionalCest
{
    public function testAddValidRecord(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        Yii::$app->user->identity = $doctor->user;
        $I->have(TimeSlot::class, [
            'doctorId' => $doctor->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '08:00:00',
            'end' => '15:00:00'
        ]);
        $user = $I->have(User::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $user->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendPOST('records', [
            'userId' => $user->userId,
            'doctorId' => $doctor->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '08:00:00',
            'end' => '08:30:00'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->seeRecord(TimeSlot::class, [
            'id' => $response->id,
            'userId' => $response->userId,
            'doctorId' => $response->doctorId,
            'date' => $response->date,
            'start' => $response->start,
            'end' => $response->end,
        ]);
    }
}
