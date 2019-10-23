<?php

use Illuminate\Database\Seeder;

class EateryOrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EateryOrderDetail::class, 50)->create();
    }
}
