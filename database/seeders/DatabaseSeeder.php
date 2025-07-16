<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AdminUserSeeder::class,
            MsLevelSeeder::class,
            MsGroupModuleSeeder::class,
            MsModuleSeeder::class,
            MsOptionSeeder::class,
            KrsSeeder::class
        ]);

        // run
        // php artisan db:seed

    }
}
