<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 27.02.18
 * Time: 17:31
 */

use League\FactoryMuffin\Faker\Facade as Faker;
use common\models\Doctor;
use common\models\User;

$fm->define(Doctor::class)->setDefinitions([
    'userId' => function (Doctor $model) use ($fm) {
        $user = $fm->create(User::class, ['type' => 'doctor']);
        return $user->userId;
    },                                      // Set the userId attribute to userId of new user
    'specialization' => Faker::jobTitle(),  // Set the spec attribute to a random job
]);
