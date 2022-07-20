<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Ashraf Ali',
                'phone' => '201030352715',
                'email' => 'admin@admin.com',
                'type' => 'admin',
                'password' => Hash::make('123456')
            ],
            [
                'name' => 'Ashraf Ali',
                'phone' => '201030352710',
                'email' => 'user@user.com',
                'type' => 'user',
                'password' => Hash::make('123456')
            ],
            [
                'name' => 'Ashraf Ali',
                'phone' => '201030752710',
                'email' => 'provider@provider.com',
                'type' => 'provider',
                'password' => Hash::make('123456')
            ]
        ]);
    }
}
