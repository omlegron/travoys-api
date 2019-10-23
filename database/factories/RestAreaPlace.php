<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\RestAreaPlace;
use Faker\Generator as Faker;

$factory->define(RestAreaPlace::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rest_area_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'rest_area_place_type_id' => $faker->randomElement($array = array (1, 2, 3, 4)),
    ];
});
