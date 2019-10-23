<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\EateryOrder;
use Faker\Generator as Faker;

$factory->define(EateryOrder::class, function (Faker $faker) {
    return [
        'code' => 'TR' . $faker->date($format = 'ymd', $max = 'now') . $faker->numberBetween($min = 1, $max = 50),
        'user_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'eatery_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'status' => $faker->randomElement($array = array ('pre-order', 'ordered', 'ready', 'paid', 'canceled')),
        'paid_date' => null,
    ];
});
