<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 06.03.18
 * Time: 9:53
 */

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\AccessToken;
use common\models\User;
use backend\tests\functional\baseCest\BaseFunctionalCest;

class UserAuthorizeActionCest extends BaseFunctionalCest
{
    public function testAuthorize(FunctionalTester $I)
    {
        $I->have(User::class, [
            'firstName' => 'Dmitry',
            'lastName'  => 'Kozlov',
            'email' => 'd.kozlov@mail.ru',
            'password' => 'parol-karol',
            'type' => 'user',
        ]);
        $I->sendPOST('users/authorize', [
            'email' => 'd.kozlov@mail.ru',
            'password' => 'parol-karol'
            ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'token' => 'string',
            'userId' => 'integer'
        ]);
        $response = json_decode($I->grabResponse());
        $I->seeRecord(AccessToken::class, [
            'userId' => $response->userId,
            'token' => $response->token
            ]);
    }

    public function testAuthorizeByWrongUser(FunctionalTester $I)
    {
        $I->have(User::class, [
            'firstName' => 'Dmitry',
            'lastName'  => 'Kozlov',
            'email' => 'd.kozlov@mail.ru',
            'password' => 'parol-karol',
            'type' => 'user',
        ]);
        $I->sendPOST('users/authorize', [
            'email' => 'd_kozlov@mail.ru',
            'password' => 'parol-karol'
        ]);
        $I->seeResponseCodeIs(401);
    }

    public function testAuthorizeWithWrongPassword(FunctionalTester $I)
    {
        $I->have(User::class, [
            'firstName' => 'Dmitry',
            'lastName'  => 'Kozlov',
            'email' => 'd.kozlov@mail.ru',
            'password' => 'parol-karol',
            'type' => 'user',
        ]);
        $I->sendPOST('users/authorize', [
            'email' => 'd.kozlov@mail.ru',
            'password' => 'parol-karol123'
        ]);
        $I->seeResponseCodeIs(401);
    }
}
