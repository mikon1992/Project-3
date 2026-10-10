<?php

use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TokoController::class, 'index'])->name('index');
Route::get('/keranjang', [TokoController::class, 'keranjang'])->name('keranjang');
Route::post('/keranjang/tambah/{barang}', [TokoController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/kerangjang/hapus/{barang}', [TokoController::class, 'kurang'])->name('keranjang.kurang');
Route::post('/keranjang/hapus/{barang}', [TokoController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/kosongkan', [TokoController::class, 'kosongkan'])->name('keranjang.kosongkan');

