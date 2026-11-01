<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Forwarding;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Andi Pratama', 'email' => 'andi@demo.id', 'role' => 'pelapor'],
            ['name' => 'Maya Lestari', 'email' => 'maya@demo.id', 'role' => 'pelapor'],
            ['name' => 'Sari Wulandari', 'email' => 'sari@demo.id', 'role' => 'relawan'],
            ['name' => 'Budi Santoso', 'email' => 'budi@demo.id', 'role' => 'koordinator'],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'password' => Hash::make('karhutla123'),
                ],
            );
        }

        $andi = User::where('email', 'andi@demo.id')->firstOrFail();
        $maya = User::where('email', 'maya@demo.id')->firstOrFail();
        $sari = User::where('email', 'sari@demo.id')->firstOrFail();
        $budi = User::where('email', 'budi@demo.id')->firstOrFail();

        $areaData = [
            ['name' => 'Kecamatan Cimenyan', 'type' => 'Kecamatan'],
            ['name' => 'Kecamatan Pangalengan', 'type' => 'Kecamatan'],
            ['name' => 'Kecamatan Rancaekek', 'type' => 'Kecamatan'],
            ['name' => 'Kawasan Gunung Puntang', 'type' => 'Kawasan'],
        ];

        foreach ($areaData as $data) {
            Area::updateOrCreate(['name' => $data['name']], ['type' => $data['type'], 'is_active' => true]);
        }

        $areas = Area::query()->get()->keyBy('name');
        $items = [
            ['title' => 'Asap tebal dekat kebun pinus', 'description' => 'Asap pekat terlihat dari lereng timur dekat jalur kebun.', 'user' => $andi, 'area' => 'Kecamatan Cimenyan', 'severity' => 'berat', 'status' => 'submitted', 'hours' => 0.5],
            ['title' => 'Asap tipis di lahan terbuka', 'description' => 'Asap tipis tampak dari sisi jalan perkebunan.', 'user' => $maya, 'area' => 'Kecamatan Pangalengan', 'severity' => 'ringan', 'status' => 'under_review', 'hours' => 4],
            ['title' => 'Titik asap baru di sisi utara', 'description' => 'Asap muncul dari semak dekat batas lahan.', 'user' => $andi, 'area' => 'Kecamatan Cimenyan', 'severity' => 'sedang', 'status' => 'flagged', 'hours' => 10],
            ['title' => 'Bau asap di jalur pendakian', 'description' => 'Bau asap tercium di jalur bawah, sumber belum terlihat.', 'user' => $maya, 'area' => 'Kawasan Gunung Puntang', 'severity' => 'sedang', 'status' => 'forwarded', 'hours' => 16],
            ['title' => 'Asap dari area ilalang', 'description' => 'Asap terlihat dari lahan ilalang di dekat saluran air.', 'user' => $andi, 'area' => 'Kecamatan Rancaekek', 'severity' => 'berat', 'status' => 'closed', 'hours' => 26],
            ['title' => 'Kepulan asap di batas perkebunan', 'description' => 'Asap terlihat sesekali dan menipis setelah hujan.', 'user' => $maya, 'area' => 'Kecamatan Cimenyan', 'severity' => 'ringan', 'status' => 'closed', 'hours' => 35],
            ['title' => 'Asap dari lahan kering', 'description' => 'Gumpalan asap terlihat dari jalan kabupaten.', 'user' => $andi, 'area' => 'Kecamatan Pangalengan', 'severity' => 'berat', 'status' => 'submitted', 'hours' => 48],
            ['title' => 'Asap kecil dekat saluran', 'description' => 'Asap kecil terlihat di dekat saluran irigasi.', 'user' => $maya, 'area' => 'Kecamatan Rancaekek', 'severity' => 'sedang', 'status' => 'flagged', 'hours' => 60],
            ['title' => 'Kepulan di bukit sisi barat', 'description' => 'Kepulan terlihat dari area parkir, sumber belum teridentifikasi.', 'user' => $andi, 'area' => 'Kawasan Gunung Puntang', 'severity' => 'sedang', 'status' => 'under_review', 'hours' => 72],
            ['title' => 'Titik asap dekat kebun teh', 'description' => 'Titik asap terlihat dari jalur inspeksi kebun.', 'user' => $maya, 'area' => 'Kecamatan Pangalengan', 'severity' => 'ringan', 'status' => 'forwarded', 'hours' => 84],
            ['title' => 'Asap tipis di lahan kosong', 'description' => 'Asap tipis terlihat dari sisi timur lahan kosong.', 'user' => $andi, 'area' => 'Kecamatan Rancaekek', 'severity' => 'ringan', 'status' => 'submitted', 'hours' => 96],
            ['title' => 'Asap dekat jalur kebun', 'description' => 'Kepulan terlihat beberapa menit dari jalur kebun.', 'user' => $maya, 'area' => 'Kecamatan Cimenyan', 'severity' => 'berat', 'status' => 'closed', 'hours' => 108],
        ];

        foreach ($items as $item) {
            $reviewed = in_array($item['status'], ['under_review', 'flagged', 'forwarded', 'closed'], true);
            $report = Report::updateOrCreate(
                ['title' => $item['title'], 'user_id' => $item['user']->id],
                [
                    'area_id' => $areas[$item['area']]->id,
                    'description' => $item['description'],
                    'latitude' => -6.8 - ($item['hours'] / 1000),
                    'longitude' => 107.5 + ($item['hours'] / 1000),
                    'occurred_at' => now()->subHours((int) $item['hours']),
                    'severity' => $item['severity'],
                    'status' => $item['status'],
                    'reviewer_id' => $reviewed ? $sari->id : null,
                    'review_note' => $reviewed ? 'Informasi lokasi dan waktu telah ditinjau relawan.' : null,
                    'reviewed_at' => $reviewed ? now()->subHours((int) $item['hours'])->addMinutes(15) : null,
                ],
            );

            if (in_array($item['status'], ['forwarded', 'closed'], true) && in_array($item['title'], ['Bau asap di jalur pendakian', 'Titik asap dekat kebun teh'], true)) {
                Forwarding::updateOrCreate(
                    ['report_id' => $report->id],
                    [
                        'coordinator_id' => $budi->id,
                        'forwarded_to' => 'BPBD Kabupaten Bandung',
                        'note' => 'Informasi diteruskan untuk pengecekan pihak terkait.',
                        'forwarded_at' => now()->subHours((int) $item['hours'])->addMinutes(30),
                    ],
                );
            }
        }
    }
}
