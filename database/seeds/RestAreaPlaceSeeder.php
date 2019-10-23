<?php

use Illuminate\Database\Seeder;

class RestAreaPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\RestAreaPlace::class, 200)->create();
    }
}
