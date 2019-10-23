<?php

use Illuminate\Database\Seeder;

class VoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Voucher::class, 3)->create()->each(function ($voucher) {
            $voucher->codes()->saveMany(factory(App\VoucherCode::class, 50)->make());
        });
    }
}
