<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 13.03.18
 * Time: 11:10
 */

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\AccessToken;
use backend\tests\functional\baseCest\BaseFunctionalCest;

class AuthenticationCest extends BaseFunctionalCest
{
    public function testUnauthorizedUserCanNotSeeListOfDoctors(FunctionalTester $I)
    {
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(401);
    }

    public function testAuthorizedUserCanSeeListOfDoctors(FunctionalTester $I)
    {
        $accessToken = $I->have(AccessToken::class);
        $I->amHttpAuthenticated($accessToken->token, '');
        $I->sendGET('doctors');
        $I->seeResponseCodeIs(200);
    }
}
