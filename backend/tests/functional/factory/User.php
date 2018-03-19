<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 05.03.18
 * Time: 11:50
 */

use League\FactoryMuffin\Faker\Facade as Faker;
use common\models\User;

$fm->define(User::class)->setDefinitions([
    'firstName' => Faker::firstName(),      // Set the firstname attribute to a random first name
    'lastName'  => Faker::lastName(),       // Set the lastname attribute to a random last name
    'email' => Faker::freeEmail(),
    'password' => Faker::password(),
    'type' => 'user'
]);
