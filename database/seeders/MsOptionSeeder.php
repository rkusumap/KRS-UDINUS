<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ms_option')->insert([
            'id_option' => 1,
            'primary_color_option' => '#6777ef',
            'primary_color_shadow_option' => '#acb5f6',
            'primary_color_focus_button_option' => '#394eea',
            'primary_color_focus_input_border_option' => '#95a0f4',
            'logo_app_option' => 'logo-20250612093925-stisla-fill.webp',
            'logo_mini_app_option' => 'logo-mini-20250612093926-stisla-fill.webp',
            'name_app_option' => 'ADMIN WEB',
            'acronym_name_app_option' => 'AW',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
    }
}
