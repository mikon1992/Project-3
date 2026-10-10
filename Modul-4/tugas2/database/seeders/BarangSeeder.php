<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['RTX 3080', 8000000, 7],
            ['ryzen 5 5600X', 3000000, 10],
            ['RAM 16GB', 4000000, 20],
            ['SSD 1TB', 25000000, 12],
            ['Mouse Wireless', 150000, 60],
        ];

        foreach ($data as [$nama, $harga, $stok]) {
            Barang::create(compact('nama', 'harga', 'stok'));
        }
    }
}