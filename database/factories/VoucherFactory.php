<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Voucher;
use Faker\Generator as Faker;

$factory->define(Voucher::class, function (Faker $faker) {
    return [
        'name' => $faker->company . ' Gift Card',
        'short_description' => $faker->sentence(),
        'point' => $faker->randomDigitNotNull * 1000,
        'amount' => $faker->randomDigitNotNull * 10000,
        'image_url' => $faker->imageUrl(),
    ];
});
