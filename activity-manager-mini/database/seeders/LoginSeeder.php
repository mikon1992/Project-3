<?php

// -> database/seeders/LoginSeeder.php
// Jalankan: php artisan db:seed --class=LoginSeeder
// Akun baseline W05 (belum ada role). Password demo hanya untuk lokal.

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LoginSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('username', 'budi')->first() ?? new User();
        $user->username     = 'budi';
        $user->nama_lengkap = 'Budi';
        $user->password     = Hash::make('password123');

        // Kolom bawaan Laravel (name, email) diisi bila ada, agar tidak NOT NULL error
        if (Schema::hasColumn('users', 'name')) {
            $user->name = 'Budi';
        }
        if (Schema::hasColumn('users', 'email')) {
            $user->email = 'budi@example.test';
        }

        $user->save();
    }
}
