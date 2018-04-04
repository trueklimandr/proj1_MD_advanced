<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 14.03.18
 * Time: 16:14
 */

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\TimeSlot;
use backend\tests\functional\baseCest\BaseFunctionalCest;
use common\models\AccessToken;
use common\models\Doctor;
use common\models\User;

class DoctorAddTimeSlotActionCest extends BaseFunctionalCest
{
    public function testAddValidTimeSlot(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $doctor->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendPOST('time-slots', [
            'doctorId' => $doctor->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '08:00:00',
            'end' => '15:00:00'
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesXPath('//id');
        $response = json_decode($I->grabResponse());
        $I->seeRecord(TimeSlot::class, [
            'id' => $response->id,
            'doctorId' => $response->doctorId,
            'date' => $response->date,
            'start' => $response->start,
            'end' => $response->end,
        ]);
    }
    /**
     * @example(start1="08:00:00", end1="09:00:00", start2="10:00:00", end2="11:00:00", code="201")
     * @example(start1="08:00:00", start2="09:00:00", end1="10:00:00", end2="11:00:00", code="422")
     * @example(start1="08:00:00", start2="09:00:00", end2="10:00:00", end1="11:00:00", code="422")
     * @example(start2="08:00:00", start1="09:00:00", end1="10:00:00", end2="11:00:00", code="422")
     * @example(start2="08:00:00", start1="09:00:00", end2="10:00:00", end1="11:00:00", code="422")
     * @example(start2="08:00:00", end2="09:00:00", start1="10:00:00", end1="11:00:00", code="201")
     */
    public function testAddIncorrectDueToIntersectionTimeSlot(FunctionalTester $I, \Codeception\Example $example)
    {
        $doctor = $I->have(Doctor::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $doctor->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->amLoggedInAs($doctor->user);
        $timeSlot = $I->have(TimeSlot::class, [
            'doctorId' =>$doctor->doctorId,
            'start' => $example['start1'],
            'end' => $example['end1']
        ]);
        $I->sendPOST('time-slots', [
            'doctorId' => $timeSlot->doctorId,
            'date' => $timeSlot->date,
            'start' => $example['start2'],
            'end' => $example['end2']
        ]);
        $I->seeResponseCodeIs($example['code']);
    }

    public function testAddIncorrectPeriodOfTimeSlot(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $doctor->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendPOST('time-slots', [
            'doctorId' => $doctor->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '12:00:00',
            'end' => '09:00:00'
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function testAddValidTimeSlotByOtherDoctor(FunctionalTester $I)
    {
        $doctor2 = $I->have(Doctor::class);
        $doctor = $I->have(Doctor::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $doctor->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendPOST('time-slots', [
            'doctorId' => $doctor2->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '08:00:00',
            'end' => '15:00:00'
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function testAddValidTimeSlotByUser(FunctionalTester $I)
    {
        $doctor = $I->have(Doctor::class);
        $user = $I->have(User::class);
        $accessToken = $I->have(AccessToken::class, ['userId' => $user->userId]);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendPOST('time-slots', [
            'doctorId' => $doctor->doctorId,
            'date' => date('Y-m-d', strtotime('tomorrow')),
            'start' => '08:00:00',
            'end' => '15:00:00'
        ]);
        $I->seeResponseCodeIs(422);
    }
}
