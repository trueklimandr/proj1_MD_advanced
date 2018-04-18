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
        $accessToken = $I->have(AccessToken::class);
        $I->amHttpAuthenticated($accessToken['token'], '');
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(0, count($response));
    }

    public function testGettingListOfThreeDocs(FunctionalTester $I)
    {
        $accessToken = $I->have(AccessToken::class);
        $I->amHttpAuthenticated($accessToken['token'], '');
        $I->haveMultiple(Doctor::class, 3);
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(3, count($response));
        $I->seeResponseMatchesJsonType([
            'doctorId' => 'integer',
            'specialization' => 'string',
        ]);
    }
}
