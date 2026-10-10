<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['nama_barang' => 'HG RX-78-2 Gundam',        'harga' => 285000, 'stok' => 15, 'gambar' => 'HG-RX78.jpg',    'deskripsi' => 'Kit grade HG skala 1/144, mobile suit klasik yang cocok untuk pemula.'],
            ['nama_barang' => 'HG Gundam Barbatos',         'harga' => 310000, 'stok' => 10, 'gambar' => 'HG-Barbatos.jpg','deskripsi' => 'Kit grade HG skala 1/144 dengan desain mecha bergaya medieval.'],
            ['nama_barang' => 'RG Zaku II',                 'harga' => 395000, 'stok' => 8,  'gambar' => 'RG-ZakuII.jpg', 'deskripsi' => 'Kit grade RG skala 1/144, detail tinggi dengan rangka dalam (inner frame).'],
            ['nama_barang' => 'MG Sinanju Ver.Ka',          'harga' => 1250000,'stok' => 4,  'gambar' => 'MG-Sinanju.jpg','deskripsi' => 'Kit grade MG skala 1/100, salah satu kit paling populer dengan artikulasi lengkap.'],
            ['nama_barang' => 'HG Unicorn Gundam',          'harga' => 340000, 'stok' => 12, 'gambar' => 'HG-Unicorn.jpg','deskripsi' => 'Kit grade HG dengan mekanisme transformasi psycho-frame bercahaya.'],
            ['nama_barang' => 'HG Gundam Exia',             'harga' => 275000, 'stok' => 0,  'gambar' => 'HG-Exia.jpg',   'deskripsi' => 'Kit grade HG dengan dua pedang GN dan sayap fleksibel. Stok sedang habis.'],
            ['nama_barang' => 'MG Freedom Gundam Ver.2.0',  'harga' => 980000, 'stok' => 6,  'gambar' => 'MG-Fredom.jpg', 'deskripsi' => 'Kit grade MG dengan sayap beam yang bisa mengembang penuh.'],
            ['nama_barang' => 'HG Sazabi',                  'harga' => 420000, 'stok' => 5,  'gambar' => 'HG-Sazabi.jpg', 'deskripsi' => 'Kit grade HG skala besar, mobile suit komando dengan funnel.'],
            ['nama_barang' => 'RG Nu Gundam',               'harga' => 410000, 'stok' => 7,  'gambar' => 'RG-NU.jpg',     'deskripsi' => 'Kit grade RG dengan fin funnel dan detail rangka dalam.'],
            ['nama_barang' => 'HG Gundam Aerial',           'harga' => 300000, 'stok' => 9,  'gambar' => 'HG-Aerial.jpg', 'deskripsi' => 'Kit grade HG dari seri terbaru, desain ramping dengan banyak aksesori.'],
            ['nama_barang' => 'MG Wing Gundam Zero EW',     'harga' => 890000, 'stok' => 3,  'gambar' => 'MG-Wing.jpg',   'deskripsi' => 'Kit grade MG dengan sayap bulu (feather effect) ikonik.'],
            ['nama_barang' => 'HG Char\'s Zaku II',          'harga' => 295000, 'stok' => 11, 'gambar' => 'HG-Zaku.jpg',   'deskripsi' => 'Varian warna merah ikonik dengan performa tiga kali lipat.'],
        ];

        foreach ($products as $item) {
            Product::create($item);
        }
    }
}