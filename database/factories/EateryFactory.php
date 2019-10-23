<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Eatery;
use Faker\Generator as Faker;

$factory->define(Eatery::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rest_area_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)),
        'contact' => $faker->unique()->e164PhoneNumber,
    ];
});
