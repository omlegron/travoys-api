<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'feedback' => $faker->text(),
    ];
});
