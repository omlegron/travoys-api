<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\RestArea;
use Faker\Generator as Faker;

$factory->define(RestArea::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'highway_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
    ];
});
