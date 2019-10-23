<?php

use App\TravAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($user) {
            TravAccount::createWithAttributes([
                'user_id' => $user->id,
                'code' => $this->randomCode(),
            ]);
            $user->feedback()->save(factory(App\Feedback::class)->make());
        });
    }

    /**
     * Generate random code for travAccount
     *
     * @param  array  $data
     * @return \App\User
     */
    public function randomCode()
    {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $max = strlen($characters) - 1;
        $code = "";

        for ($i = 0; $i < 7; $i++) {
            $code .= $characters[mt_rand(0, $max)];
        }

        $validator = Validator::make(['code' => $code], [
            'code' => 'unique:trav_accounts,code',
        ]);

        if ($validator->fails()) {
            return $this->randomCode();
        }

        return $code;
    }
}
