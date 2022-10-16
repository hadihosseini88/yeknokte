<?php

namespace Hadihosseini88\User\Database\Seeds;

use Hadihosseini88\User\Models\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::$defaultUsers as $user) {
            User::firstOrCreate(
                [
                    'email'=>$user['email']
                ],
                [
                'email'=> $user['email'],
                'name'=> $user['name'],
                'password'=> bcrypt($user['password']),
            ])->assignRole($user['role'])->markEmailAsVerified();
        }

    }
}
