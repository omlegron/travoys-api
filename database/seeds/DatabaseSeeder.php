<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            // VehicleClassSeeder::class,
            // VehicleClassDetailSeeder::class,
            // RestAreaPlaceTypeSeeder::class,
            // HighwaySeeder::class,
            // RestAreaSeeder::class,
            // RestAreaPlaceSeeder::class,
            // RestAreaPlaceFacilitySeeder::class,
            CitiesTableSeeder::class,
            // EaterySeeder::class,
            // EateryMenuSeeder::class,
            // EateryOrderSeeder::class,
            // EateryOrderDetailSeeder::class,
            VoucherTableSeeder::class,
        ]);
    }
}
