<?php

use App\Http\Controllers\LandingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PengumumanController;


Route::get('/admin', [WelcomeController::class, 'index']);

// Halaman utama atau landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

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

    // Cek NIM untuk validasi
    Route::get('/check-nim/{nim}', [RegistrasiController::class, 'checkNIM'])->name('registrasi.checkNIM');
});

// Route untuk tampilan jadwal
Route::get('/schedule', function () {
    return view('schedule.schedule');
});

Route::get('/peserta', function () {
    return view('peserta.index');
});
