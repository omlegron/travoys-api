<?php

use Illuminate\Database\Seeder;

class RestAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\RestArea::class, 100)->create();
    }
}
