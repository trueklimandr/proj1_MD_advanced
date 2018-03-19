<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 15.03.18
 * Time: 12:07
 */

use League\FactoryMuffin\Faker\Facade as Faker;
use common\models\TimeSlot;
use common\models\Doctor;

$fm->define(TimeSlot::class)->setDefinitions([
    'doctorId' => function (TimeSlot $model) use ($fm) {
        $doctor = $fm->create(Doctor::class);
        return $doctor->doctorId;
    },                                                   // Set the doctorId attribute to doctorId of new doctor
    'date' => function() {
        $date = Faker::dateTimeBetween('now', '+1 week')();
        return $date->format('Y-m-d');
    },                                                   // Set the date attribute to random next week date
    'start' => function() {
        $date = Faker::dateTimeBetween('07:30', '09:30')();
        return $date->format('H:i:s');
    },                                                   // Set the start time to random
    'end' => function() {
        $date = Faker::dateTimeBetween('10:00', '12:00')();
        return $date->format('H:i:s');
    }                                                    // Set the end time to random
]);
