<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Place;
use Faker\Generator as Faker;

$factory->define(Place::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'photo_url' => $faker->imageUrl(),
        'category_id' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8']),
        'longitude' => $faker->latitude(),
        'latitude' => $faker->longitude(),
    ];
});
