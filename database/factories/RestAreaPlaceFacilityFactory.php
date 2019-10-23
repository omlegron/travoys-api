<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\RestAreaPlaceFacility;
use Faker\Generator as Faker;

$factory->define(RestAreaPlaceFacility::class, function (Faker $faker) {
    return [
        'rest_area_place_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'name' => $faker->name,
    ];
});
