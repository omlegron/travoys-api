<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\City::class, 20)->create()->each(function ($city) {
            $city->places()->save(factory(App\Place::class)->make());
            $city->places()->save(factory(App\Place::class)->make());
            $city->places()->save(factory(App\Place::class)->make());
        });
    }
}
