<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\TanamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Rute untuk menampilkan halaman login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Rute untuk memproses data dari form login
Route::post('login', [AuthController::class, 'loginProcess']);

// Rute untuk menampilkan halaman registrasi
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

// Rute untuk memproses data dari form registrasi
Route::post('register', [AuthController::class, 'registerProcess']);

// Rute untuk logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Grup untuk semua halaman yang hanya bisa diakses oleh Admin
Route::middleware(['auth', 'admin:Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Nanti semua Rute Admin (CRUD Kriteria, Tanaman, dll) kita letakkan di sini
    // contoh: Route::get('kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('tanaman', TanamanController::class);
    Route::resource('users', UserController::class);
});

// Rute dashboard bisa diakses semua peran yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan', [PerhitunganController::class, 'hitung'])->name('perhitungan.hitung');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
});
