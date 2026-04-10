<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggajianController;

// Redirect "/" langsung ke login
Route::get('/', fn() => redirect()->route('login'))->name('landing');

// Auth (hanya untuk guest)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Ubah password (semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/ubah-password',  [AuthController::class, 'showUbahPassword'])->name('ubah-password');
    Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);
});

// Semua halaman berikut butuh login
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hanya admin
    Route::middleware('admin')->group(function () {
        Route::resource('departemen', DepartemenController::class)->except(['show']);
        Route::resource('jabatan',    JabatanController::class)->except(['show']);
        Route::resource('karyawan',   KaryawanController::class)->except(['show']);

        // Kategori.index sekarang menampilkan rekap penggajian
        Route::get('/kategori', [PenggajianController::class, 'rekapKategori'])->name('kategori.index');
        Route::resource('kategori', KategoriController::class)->except(['show', 'index']);

        // API endpoint untuk fetch nominal kategori
        Route::get('/api/kategoris', [KategoriController::class, 'apiList'])->name('api.kategoris');

        Route::get('/penggajian',        [PenggajianController::class, 'hitung'])->name('penggajian.hitung');
        Route::post('/penggajian',       [PenggajianController::class, 'store'])->name('penggajian.store');
        Route::get('/penggajian/rekap',  [PenggajianController::class, 'rekap'])->name('penggajian.rekap');
    });

});
