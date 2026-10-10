<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\api\NearbyBooksTestUserSeeder;
use Database\Seeders\api\BookSeeder;
use Database\Seeders\admin\AdminSeeder;
use Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            NearbyBooksTestUserSeeder::class,
            BookSeeder::class,
            PostSeeder::class,
        ]);
    }
}
