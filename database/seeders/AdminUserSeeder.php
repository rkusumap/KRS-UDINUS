<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'username' => 'admin',
                'status_user' => '1',
                'level_user' => 'bb110fc1-fada-4a86-b2e2-342c1017975a',
                'password' => Hash::make('admin'),
            ]
        );
    }
}
