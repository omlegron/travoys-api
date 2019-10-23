<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class RestAreaPlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types = [
            'restaurant',
            'minimarker',
            'hospital',
            'other',
        ];

        foreach ($types as $key => $type) {
            DB::table('rest_area_place_types')->insert([
                'name' => $type,
                'code' => $type,
                'created_at' => date('Y-m-d'),
            ]);
        }
    }
}
