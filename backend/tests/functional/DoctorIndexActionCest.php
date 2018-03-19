<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 28.02.18
 * Time: 11:31
 */

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\Doctor;
use common\models\AccessToken;
use backend\tests\functional\baseCest\BaseFunctionalCest;

class DoctorIndexActionCest extends BaseFunctionalCest
{
    public function testGettingListOfZeroDocs(FunctionalTester $I)
    {
        $I->have(AccessToken::class);
        $accessToken = AccessToken::find()->one();
        $I->amHttpAuthenticated($accessToken['token'], '');
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(0, count($response));
    }

    public function testGettingListOfFiveDocs(FunctionalTester $I)
    {
        $I->have(AccessToken::class);
        $accessToken = AccessToken::find()->one();
        $I->amHttpAuthenticated($accessToken['token'], '');
        $I->haveMultiple(Doctor::class, 5);
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(5, count($response));
        sleep(7);
        $I->seeResponseMatchesJsonType([
            'doctorId' => 'integer',
            'specialization' => 'string',
        ]);
    }
}
