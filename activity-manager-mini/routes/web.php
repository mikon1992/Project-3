<?php

// -> routes/web.php  (GANTI SELURUH ISI file bawaan dengan ini)

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// ---- Login (W05) ----
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware('auth')->name('dashboard');

// ---- CRUD Activities (W03-W04), hanya untuk user yang login ----
Route::resource('activities', ActivityController::class)
    ->except('show')
    ->middleware('auth');
