<?php

namespace Database\Seeders\api;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NearbyBooksTestUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'      => 'John Doe',
                'email'     => 'imalbab1@gmail.com',
                'role'      => 'user',
                'latitude'  => 40.7128,
                'longitude' => -74.0060,
                'password'  => Hash::make('123456')
            ],
            [
                'name'      => 'Alice Smith',
                'email'     => 'alice@example.com',
                'role'      => 'user',
                'latitude'  => 40.6782,
                'longitude' => -73.9442,
                'password'  => Hash::make('123456')
            ],
            [
                'name'      => 'Bob Johnson',
                'email'     => 'bob@example.com',
                'role'      => 'user',
                'latitude'  => 40.7178,
                'longitude' => -74.0431,
                'password'  => Hash::make('123456')
            ],
            [
                'name'      => 'Charlie Brown',
                'email'     => 'charlie@example.com',
                'role'      => 'user',
                'latitude'  => 40.7357,
                'longitude' => -74.1724,
                'password'  => Hash::make('123456')
            ],
        ]);
    }
}
