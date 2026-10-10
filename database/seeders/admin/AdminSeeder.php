<?php

namespace Database\Seeders\admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'      => 'Super Admin',
                'email'     => 'superadmin@gmail.com',
                'role'      => 'admin',
                'latitude'  => 40.7128,
                'longitude' => -74.0060,
                'password'  => Hash::make('123456')
            ],
            [
                'name'      => 'Admin',
                'email'     => 'admin@gmail.com',
                'role'      => 'admin',
                'latitude'  => 40.7128,
                'longitude' => -74.0060,
                'password'  => Hash::make('123456')
            ],
        ]);
    }
}
