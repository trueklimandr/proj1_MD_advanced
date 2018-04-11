<?php
/**
 * Created by PhpStorm.
 * User: andersen
 * Date: 11.04.18
 * Time: 13:53
 */

return [
    [
        'id' => '1',
        'doctorId' => '1',
        'date' => date('Y-m-d', strtotime('today')),
        'start' => '08:00',
        'end' => '12:00',
    ],
    [
        'id' => '2',
        'doctorId' => '1',
        'date' => date('Y-m-d', strtotime('tomorrow')),
        'start' => '08:00',
        'end' => '12:00',
    ],
    [
        'id' => '3',
        'doctorId' => '1',
        'date' => date('Y-m-d', strtotime('tomorrow +1 day')),
        'start' => '14:00',
        'end' => '17:00',
    ],
    [
        'id' => '4',
        'doctorId' => '2',
        'date' => date('Y-m-d', strtotime('tomorrow')),
        'start' => '08:00',
        'end' => '12:00',
    ],
    [
        'id' => '5',
        'doctorId' => '2',
        'date' => date('Y-m-d', strtotime('tomorrow +1 day')),
        'start' => '08:00',
        'end' => '12:00',
    ],
    [
        'id' => '6',
        'doctorId' => '3',
        'date' => date('Y-m-d', strtotime('tomorrow')),
        'start' => '10:00',
        'end' => '14:30',
    ],
];
