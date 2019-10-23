<?php

use Illuminate\Database\Seeder;

class EateryMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EateryMenu::class, 200)->create();
    }
}
