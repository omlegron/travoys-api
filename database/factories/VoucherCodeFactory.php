<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\VoucherCode;
use Faker\Generator as Faker;

$factory->define(VoucherCode::class, function (Faker $faker) {
    return [
        'code' => Str::random(16),
        'expired_at' => now()->addMonth(12),
    ];
});
