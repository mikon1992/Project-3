<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AreaSummaryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForwardingController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('reports.index'));
    Route::get('/home', fn () => redirect()->route('reports.index'))->name('home');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('/areas/{area}/summary', [AreaSummaryController::class, 'show'])->name('areas.summary');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/{report}/evidence', [ReportController::class, 'evidence'])->name('reports.evidence');
    Route::post('/reports/{report}/claim', [ReportController::class, 'claim'])->middleware('role:relawan')->name('reports.claim');
    Route::post('/reports/{report}/flag', [ReportController::class, 'flag'])->middleware('role:relawan')->name('reports.flag');
    Route::post('/reports/{report}/close-review', [ReportController::class, 'closeReview'])->middleware('role:relawan')->name('reports.close-review');
    Route::post('/reports/{report}/forwardings', [ForwardingController::class, 'store'])->middleware('role:koordinator')->name('forwardings.store');
    Route::post('/reports/{report}/close-forwarded', [ForwardingController::class, 'close'])->middleware('role:koordinator')->name('reports.close-forwarded');

    Route::middleware('role:relawan,koordinator')->group(function () {
        Route::get('/recap', [RecapController::class, 'index'])->name('reports.recap');
    });

    Route::middleware('role:koordinator')->group(function () {
        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
        Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
        Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
    });
});