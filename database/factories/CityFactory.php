<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'photo_url' => $faker->imageUrl(),
        'longitude' => $faker->latitude(),
        'latitude' => $faker->longitude(),
    ];
});
