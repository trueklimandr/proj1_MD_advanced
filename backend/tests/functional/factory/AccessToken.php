<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 13.03.18
 * Time: 11:25
 */

use League\FactoryMuffin\Faker\Facade as Faker;
use common\models\AccessToken;
use common\models\User;

$fm->define(AccessToken::class)->setDefinitions([
    'userId' => function (AccessToken $model) use ($fm) {
        $user = $fm->create(User::class, ['type' => 'user']);
        return $user->userId;
    },                                      // Set the userId attribute to userId of new user
    'token' => Faker::password(32, 32),     // Set the token attribute to a random string length 32
]);
