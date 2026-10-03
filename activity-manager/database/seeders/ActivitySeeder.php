<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');

        $rows = [
            ['code' => 'SEM-001', 'title' => 'Seminar Laravel Dasar', 'slug' => 'seminar'],
            ['code' => 'SEM-002', 'title' => 'Seminar Data Integrity', 'slug' => 'seminar'],
            ['code' => 'SEM-003', 'title' => 'Seminar Clean Code', 'slug' => 'seminar'],
            ['code' => 'SEM-004', 'title' => 'Seminar Web Security', 'slug' => 'seminar'],
            ['code' => 'SEM-005', 'title' => 'Seminar Database Design', 'slug' => 'seminar'],
            ['code' => 'SEM-006', 'title' => 'Seminar Git Workflow', 'slug' => 'seminar'],
            ['code' => 'WRK-001', 'title' => 'Workshop Blade', 'slug' => 'workshop'],
            ['code' => 'WRK-002', 'title' => 'Workshop Query Builder', 'slug' => 'workshop'],
            ['code' => 'WRK-003', 'title' => 'Workshop Validation', 'slug' => 'workshop'],
            ['code' => 'WRK-004', 'title' => 'Workshop Transaction', 'slug' => 'workshop'],
            ['code' => 'WRK-005', 'title' => 'Workshop File Storage', 'slug' => 'workshop'],
            ['code' => 'WRK-006', 'title' => 'Workshop Refactoring', 'slug' => 'workshop'],
            ['code' => 'CMP-001', 'title' => 'Kompetisi Algoritma', 'slug' => 'kompetisi'],
            ['code' => 'CMP-002', 'title' => 'Kompetisi Web Design', 'slug' => 'kompetisi'],
            ['code' => 'CMP-003', 'title' => 'Kompetisi Fotografi', 'slug' => 'kompetisi'],
            ['code' => 'CMP-004', 'title' => 'Kompetisi UI Challenge', 'slug' => 'kompetisi'],
            ['code' => 'CMP-005', 'title' => 'Kompetisi Coding Sprint', 'slug' => 'kompetisi'],
            ['code' => 'CMP-006', 'title' => 'Kompetisi Database Sprint', 'slug' => 'kompetisi'],
        ];

        foreach ($rows as $index => $row) {
            $start = now()->addDays($index + 2)->setTime(9, 0);

            Activity::updateOrCreate(
                ['code' => $row['code']],
                [
                    'category_id' => $categories[$row['slug']],
                    'title' => $row['title'],
                    'description' => 'Data latihan untuk Modul 3 Special Challenge.',
                    'start_at' => $start,
                    'end_at' => (clone $start)->addHours(2),
                    'location' => 'Lab Kampus',
                    'capacity' => 100,
                    'registered_count' => 0,
                    'status' => $index < 6 ? 'published' : 'draft',
                    'poster_path' => null,
                ]
            );
        }
    }
}
