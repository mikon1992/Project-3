namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder {
    public function run(): void {
        Activity::insert([
            [
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository.',
                'activity_date' => '2026-10-05',
                'category' => 'Workshop',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability dan testing.',
                'activity_date' => '2026-10-12',
                'category' => 'Seminar',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rapat Proyek Akhir',
                'description' => 'Diskusi pembagian tugas.',
                'activity_date' => '2026-10-15',
                'category' => 'Meeting',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pengumpulan Modul 1',
                'description' => 'Submit tugas ke e-learning.',
                'activity_date' => '2026-09-20',
                'category' => 'Tugas',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Presentasi Kelompok',
                'description' => 'Demo aplikasi ke dosen.',
                'activity_date' => '2026-10-20',
                'category' => 'Presentasi',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}