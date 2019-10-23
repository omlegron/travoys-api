<?php

use Illuminate\Database\Seeder;

class HighwaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Highway::class, 10)->create();
    }
}
