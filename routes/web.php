<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Halaman utama atau landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Menampilkan form login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('login', [LoginController::class, 'login']);

// Route logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Halaman dashboard (hanya bisa diakses jika sudah login)
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk request reset password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Route Registrasi
Route::prefix('registrasi')->group(function () {
    // Halaman registrasi
    Route::get('/', [RegistrasiController::class, 'create'])->name('registrasi.create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('registrasi.store');
    
    // AJAX untuk ambil Prodi berdasarkan Jurusan
    Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('registrasi.getProdi');
});
