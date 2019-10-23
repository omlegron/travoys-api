<?php

use Illuminate\Database\Seeder;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Eatery::class, 100)->create();
    }
}
