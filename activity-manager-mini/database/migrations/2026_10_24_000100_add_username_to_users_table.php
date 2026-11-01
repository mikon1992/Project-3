<?php

// -> database/migrations/2026_10_24_000100_add_username_to_users_table.php
// Aman dijalankan walau kolomnya sudah ada (dicek dulu).

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username', 50)->nullable()->unique();
            }
            if (! Schema::hasColumn('users', 'nama_lengkap')) {
                $table->string('nama_lengkap', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'nama_lengkap')) {
                $table->dropColumn('nama_lengkap');
            }
        });
    }
};
