<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class VehicleClassDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($x=0; $x < 5; $x++) {
            for ($i=0; $i < 5; $i++) { 
                DB::table('vehicle_class_details')->insert([
                    'vehicle_class_id' => $x + 1,
                    'name' => $faker->name,
                    'created_at' => date('Y-m-d'),
                ]);
            }
        }
    }
}
