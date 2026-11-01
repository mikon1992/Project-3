<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Andi Pratama', 'email' => 'andi@demo.id', 'role' => 'pelapor'],
            ['name' => 'Maya Lestari', 'email' => 'maya@demo.id', 'role' => 'pelapor'],
            ['name' => 'Sari Wulandari', 'email' => 'sari@demo.id', 'role' => 'relawan'],
            ['name' => 'Budi Santoso', 'email' => 'budi@demo.id', 'role' => 'koordinator'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('karhutla123'),
                ],
            );
        }
    }
}