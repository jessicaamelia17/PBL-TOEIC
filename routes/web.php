<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ControllerPengumuman;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\SesiJadwalController;

// =============================
// 🔓 RUTE PUBLIK (TIDAK PERLU LOGIN)
// =============================

// Halaman utama
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Jadwal & daftar peserta
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('/schedule/pendaftar/{id}', [ScheduleController::class, 'pendaftar'])->name('schedule.pendaftar');

// Halaman peserta umum
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
Route::get('/hasil-ujian/pdf/view-all', [HasilController::class, 'viewAllPdf'])->name('hasil-ujian.pdf.view.all');
Route::get('/hasil-ujian/pdf/download-all', [HasilController::class, 'downloadAllPdf'])->name('hasil-ujian.pdf.download.all');
// ==========================
// 🔐 RUTE ADMIN (PERLU LOGIN)
// ==========================

// Auth - Login & Register Admin
Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login', [AdminAuthController::class, 'postlogin']);
Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('/register', [AdminAuthController::class, 'store']);
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

// Grup Rute Admin (dengan middleware dan prefix)
Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminAuthController::class, 'index'])->name('dashboard');

    // Pendaftar
    Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar/list', [PendaftarController::class, 'list'])->name('pendaftar.list');
    Route::get('/pendaftar/detail/{id}', [PendaftarController::class, 'show'])->name('pendaftar.show');

    // Jadwal Ujian
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');

    // Sesi & Room Ujian
    Route::get('/jadwal/{id}/sesi', [SesiJadwalController::class, 'index'])->name('sesi.index');
    Route::post('/jadwal/{id}/sesi', [SesiJadwalController::class, 'storeSesi'])->name('sesi.store');
    Route::post('/jadwal/{id}/room', [SesiJadwalController::class, 'storeRoom'])->name('room.store');
    Route::post('/jadwal/{id}/bagi-peserta', [SesiJadwalController::class, 'bagiPesertaKeSesiRoom'])->name('jadwal.bagi-peserta');


    // Sesi
    Route::get('/sesi/{id}/edit', [SesiJadwalController::class, 'edit'])->name('sesi.edit');
    Route::put('/sesi/{id}', [SesiJadwalController::class, 'update'])->name('sesi.update');
    Route::delete('/sesi/{id}', [SesiJadwalController::class, 'destroy'])->name('sesi.destroy');

    // Room
    Route::get('/room/{id}/edit', [SesiJadwalController::class, 'editRoom'])->name('room.edit');
    Route::put('/room/{id}', [SesiJadwalController::class, 'updateRoom'])->name('room.update');
    Route::delete('/room/{id}', [SesiJadwalController::class, 'destroyRoom'])->name('room.destroy');

    // Admin melihat semua pengumuman
    Route::get('/pengumumans', [ControllerPengumuman::class, 'index'])->name('pengumuman.index');
    // Form tambah pengumuman
    Route::get('/pengumumans/create', [ControllerPengumuman::class, 'create'])->name('pengumuman.create');
    // Simpan pengumuman
    Route::post('/pengumumans', [ControllerPengumuman::class, 'store'])->name('pengumuman.store');
    // Hapus pengumuman
    Route::delete('/pengumumans/{id}', [ControllerPengumuman::class, 'destroy'])->name('pengumuman.destroy');
    Route::post('/pengumumans/list', [ControllerPengumuman::class, 'list'])->name('pengumuman.list');
});
