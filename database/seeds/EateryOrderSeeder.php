<?php

use Illuminate\Database\Seeder;

class EateryOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EateryOrder::class, 20)->create();
    }
}
