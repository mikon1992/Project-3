<?php

// -> database/seeders/ActivitySeeder.php
// Jalankan: php artisan db:seed --class=ActivitySeeder

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Workshop Git Dasar',     'Latihan kolaborasi repository.',       '2026-10-05', 'Workshop',   'Planned'],
            ['Seminar Web Quality',    'Pengenalan maintainability dan testing.', '2026-10-12', 'Seminar',    'Planned'],
            ['Rapat Proyek Akhir',     'Diskusi pembagian tugas.',             '2026-10-15', 'Meeting',    'Ongoing'],
            ['Pengumpulan Modul 1',    'Submit tugas ke e-learning.',          '2026-09-20', 'Tugas',      'Done'],
            ['Presentasi Kelompok',    'Demo aplikasi ke dosen.',              '2026-10-20', 'Presentasi', 'Planned'],
        ];

        foreach ($rows as [$title, $description, $date, $category, $status]) {
            Activity::create([
                'title'         => $title,
                'description'   => $description,
                'activity_date' => $date,
                'category'      => $category,
                'status'        => $status,
            ]);
        }
    }
}
