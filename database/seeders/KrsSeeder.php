<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa_dinus')->insert([
            'nim_dinus'    => 'b08df36d75bdaba20d68c50da73f5aa0',
            'ta_masuk'  => '2022',
            'prodi'  => 'A11',
            'pass_mhs'  => Hash::make('12345678'),
            'kelas'  => '1',
            'akdm_stat'  => '1',
        ]);
    }
}
