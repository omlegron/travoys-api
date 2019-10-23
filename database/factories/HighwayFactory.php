<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Highway;
use Faker\Generator as Faker;

$factory->define(Highway::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start_latitude' => $faker->latitude,
        'start_longitude' => $faker->longitude,
        'end_latitude' => $faker->latitude,
        'end_longitude' => $faker->longitude,
    ];
});
