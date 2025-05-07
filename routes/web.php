<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController as ControllersAdminAuthController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\AuthorizeAdmin;

// =============================
// 🔓 RUTE PUBLIK (TIDAK PERLU LOGIN)
// =============================

// Halaman utama
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Jadwal & peserta
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('/peserta', fn() => view('peserta.index'))->name('peserta.index');

// Registrasi peserta
Route::prefix('registrasi')->name('registrasi.')->group(function () {
    Route::get('/', [RegistrasiController::class, 'create'])->name('create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('store');
    Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('getProdi');
    Route::get('/check-nim/{nim}', [RegistrasiController::class, 'checkNIM'])->name('checkNIM');
});

// Hasil ujian
Route::get('/hasil-ujian', [HasilController::class, 'index'])->name('hasil-ujian.index');

// ==========================
// 🔐 RUTE ADMIN (PERLU LOGIN)
// ==========================

// Auth - Login & Register Admin
use App\Http\Controllers\AdminAuthController;

// Rute Login & Register Admin
Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login', [AdminAuthController::class, 'postlogin']);
Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');
Route::post('/register', [AdminAuthController::class, 'store']); // GANTI store_admin -> store
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

// Rute setelah login
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/home', [AdminAuthController::class, 'index'])->name('admin.dashboard'); // ke dashboard view
    Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar/list', [PendaftarController::class, 'list'])->name('pendaftar.list');
});

