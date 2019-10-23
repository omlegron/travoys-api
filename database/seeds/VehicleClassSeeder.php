<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class VehicleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 5; $i++) { 
            DB::table('vehicle_classes')->insert([
                'class_name' => $faker->name,
                'created_at' => date('Y-m-d'),
            ]);
        }

    }
}
