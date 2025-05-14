<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController as ControllersAdminAuthController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengumumanController;
// use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\AuthorizeAdmin;
use App\Http\Controllers\Admin\SesiJadwalController;
// use App\Http\Controllers\Admin\JadwalController;
// Rute setelah login
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\JadwalController;

// =============================
// 🔓 RUTE PUBLIK (TIDAK PERLU LOGIN)
// =============================

// Halaman utama
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Route untuk menampilkan semua jadwal


Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('/schedule/pendaftar/{id}', [ScheduleController::class, 'pendaftar'])->name('schedule.pendaftar');




Route::get('/peserta', fn() => view('peserta.index'))->name('peserta.index');


// // Route untuk menampilkan semua jadwal
// Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedule.index');

// // Route untuk menampilkan detail jadwal berdasarkan ID
// Route::get('/jadwal/{id}', [ScheduleController::class, 'show'])->name('schedule.show');

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
// use App\Http\Controllers\AdminAuthController;

// Rute Login & Register Admin
Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login', [AdminAuthController::class, 'postlogin']);
Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');
Route::post('/register', [AdminAuthController::class, 'store']); // GANTI store_admin -> store
// Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');


Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/home', [AdminAuthController::class, 'index'])->name('dashboard');
    
    Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar/list', [PendaftarController::class, 'list'])->name('pendaftar.list');
    Route::get('/pendaftar/detail/{id}', [PendaftarController::class, 'show']);

        // Route untuk tampil jadwal
    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    
    // Route untuk form edit jadwal
    Route::get('jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    
    // Route untuk update jadwal
    Route::put('jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    // Route untuk mengatur sesi & room berdasarkan jadwal tertentu
    Route::get('jadwal/{id}/sesi', [SesiJadwalController::class, 'index'])->name('sesi.index');
    Route::post('jadwal/{id}/sesi', [SesiJadwalController::class, 'storeSesi'])->name('sesi.store');
    Route::post('jadwal/{id}/room', [SesiJadwalController::class, 'storeRoom'])->name('room.store');
    Route::post('jadwal/{id}/bagi-peserta', [SesiJadwalController::class, 'bagiPesertaKeSesiRoom'])->name('jadwal.bagi-peserta');




});


