<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\EateryMenu;
use Faker\Generator as Faker;

$factory->define(EateryMenu::class, function (Faker $faker) {
    return [
        'eatery_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'name' => $faker->name,
        'price' => $faker->numberBetween($min = 1, $max = 50),
        'price_for_sell' => $faker->numberBetween($min = 51, $max = 100),
        'stock' => 1000,
    ];
});
