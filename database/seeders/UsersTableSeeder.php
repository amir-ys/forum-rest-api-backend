<?php

namespace Database\Seeders;

use App\Models\User;
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
        foreach (User::$defaultUsers as $column => $user) {
            User::firstOrCreate(["email" => $user['email']], [
                    "email" => $user['email'],
                    "name" => $user['name'],
                    "password" => bcrypt($user['password'])]
            )->assignRole($user['role']);
        }


    }
}

