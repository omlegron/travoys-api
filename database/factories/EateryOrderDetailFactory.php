<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\EateryOrderDetail;
use Faker\Generator as Faker;

$factory->define(EateryOrderDetail::class, function (Faker $faker) {
    return [
        'eatery_order_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'eatery_menu_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'count' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
    ];
});
