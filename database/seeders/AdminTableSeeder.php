<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => "Admin",
            'phone' => '01030352710',
            'email' => 'admin@admin.com',
            'type' => "admin",
            'status' => 1,
            'password' => Hash::make('123456')
        ]);
    }
}
