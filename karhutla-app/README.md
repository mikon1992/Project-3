# Rimba Siaga

Aplikasi komunitas untuk pelaporan dan pemantauan indikasi kebakaran hutan dan lahan. Peninjauan relawan dan status selesai hanya menggambarkan proses aplikasi, bukan verifikasi resmi kejadian atau pernyataan bahwa api telah padam.

## Identitas

- Nama mahasiswa: isi nama
- NIM: isi NIM
- Kelas: isi kelas
- Judul: Pelaporan dan Pemantauan Kebakaran Hutan dan Lahan
- Repository: isi URL repository

## Kebutuhan

- PHP 8.3 sampai 8.5 untuk Laravel 13
- Composer
- MySQL atau MariaDB
- XAMPP Linux atau layanan PHP dan database setara

Periksa versi PHP CLI dengan `php -v`, versi framework dengan `composer show laravel/framework`, dan kecocokan dependensi dengan `composer check-platform-reqs`.

## Instalasi

1. Siapkan kerangka Laravel 13 dengan Composer.
2. Salin berkas aplikasi dari folder `karhutla-app/` ke root proyek Laravel.
3. Salin `.env.example` menjadi `.env`.
4. Atur koneksi database MySQL/MariaDB di `.env`.
5. Pasang dependensi dengan `composer install`.
6. Buat application key dengan `php artisan key:generate`.
7. Jalankan migration dan data demo dengan `php artisan migrate:fresh --seed`.
8. Jalankan aplikasi dengan `php artisan serve`.

Jangan commit `.env`. `.env.example` hanya berisi konfigurasi contoh tanpa password pribadi.

## Database

Buat database MySQL bernama `karhutla_db`, lalu sesuaikan nilai `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada `.env`. Migration membuat tabel users, areas, reports, forwardings, dan report_status_logs beserta foreign key.

Aplikasi memakai disk lokal privat Laravel untuk file bukti melalui route yang memeriksa authorization. `php artisan storage:link` tidak digunakan karena bukti tidak dibuka melalui folder publik.

## Akun demo

Semua akun menggunakan password `karhutla123`.

| Role | Nama | Email |
|---|---|---|
| Pelapor | Andi Pratama | andi@demo.id |
| Pelapor | Maya Lestari | maya@demo.id |
| Relawan | Sari Wulandari | sari@demo.id |
| Koordinator | Budi Santoso | budi@demo.id |

## Alur status

`submitted` → `under_review` → `flagged` → `forwarded` → `closed`

Relawan dapat menutup laporan dari `under_review`. Status `closed` final.

## Business rules

- BR-01: Pelapor hanya dapat mengubah atau membatalkan laporan miliknya saat `submitted`.
- BR-02: Laporan hanya dapat ditandai `flagged` setelah ditinjau dan mempunyai catatan.
- BR-03: Hanya koordinator yang dapat mencatat penerusan dari `flagged`, satu kali untuk tiap laporan.
- BR-04: Perubahan status harus mengikuti alur dan laporan `closed` tidak dapat diubah lagi.
- BR-05: Pelapor tidak dapat membuat laporan aktif di area yang sama dengan waktu kejadian dalam rentang 60 menit dari laporannya yang lain.

## Pengujian manual

Ikuti checklist lengkap di `docs/tes-AC-01-sampai-AC-13.md`.

- Uji login, logout, dan akses guest.
- Uji ownership dengan dua akun pelapor berbeda.
- Uji rentang latitude -90 sampai 90 dan longitude -180 sampai 180.
- Uji file JPG, JPEG, PNG, PDF, file tidak diizinkan, dan ukuran di atas 2 MB.
- Uji semua transisi status dan role yang berhak.
- Uji filter serta pagination dengan query tetap pada URL.
- Periksa request area summary pada DevTools Network.
- Periksa perubahan status pada tabel report_status_logs.
- Uji rekap dengan filter area dan status.
