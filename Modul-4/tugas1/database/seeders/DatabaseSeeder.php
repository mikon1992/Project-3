<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'dep',
            'password' => '123456',
            'nama_lengkap' => 'Deva Annurahman',
        ]);

        User::create([
            'username' => 'mikon',
            'password' => 'pengenpulang',
            'nama_lengkap' => 'Rafi',
        ]);
    }
}