<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ms_level')->insert([
            'id_level'    => 'bb110fc1-fada-4a86-b2e2-342c1017975a',
            'code_level'  => 'ADM',
            'name_level'  => 'Admin',
            'created_at'  => '2025-06-07 22:49:44',
            'updated_at'  => '2025-06-08 01:06:52',
            'deleted_at'  => null,
        ]);
    }
}
