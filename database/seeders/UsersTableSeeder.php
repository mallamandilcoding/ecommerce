<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        DB::table('users')->insert([
            //admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
             //vendor
             [
                'name' => 'Vender',
                'username' => 'vendar',
                'email' => 'vender@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
             //user
             [
                'name' => 'User ',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
        ]);
        //vendor

        //user
    }
}
