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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\HasilUjianController as AdminHasilController;

/*
|--------------------------------------------------------------------------
| 🔓 RUTE PUBLIK (TIDAK PERLU LOGIN)
|--------------------------------------------------------------------------
*/

// Landing Page
//login & register mahasiswa
// Route::get('/login-toeic', [AuthController::class, 'showLogin'])->name('login-toeic');
// Route::post('/login-toeic', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/register-user', [RegisterUserController::class, 'showRegister'])->name('register-user');
// Route::post('/register-user', [RegisterUserController::class, 'register']);
// // Halaman utama mahasiswa
// Route::get('/profile', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
// // Edit profile mahasiswa (form edit)
// Route::get('/profile/edit/{nim}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
// // Update profile mahasiswa (proses update)
// Route::put('/profile/edit/{nim}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
// Route::get('/get-prodi/{id_jurusan}', [MahasiswaController::class, 'getProdiByJurusan']);


// Halaman utama/ landing page mahasiswa
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Jadwal & Pendaftar
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
Route::get('/schedule/pendaftar/{id}', [ScheduleController::class, 'pendaftar'])->name('schedule.pendaftar');

// Halaman peserta umum
Route::view('/peserta', 'peserta.index')->name('peserta.index');

// Registrasi peserta
Route::prefix('registrasi')->name('registrasi.')->group(function () {
    Route::get('/', [RegistrasiController::class, 'create'])->name('create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('store');
    Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('getProdi');
    Route::get('/check-nim/{nim}', [RegistrasiController::class, 'checkNIM'])->name('checkNIM');
});

// Hasil Ujian (Peserta)
Route::prefix('hasil-ujian')->name('hasil-ujian.')->group(function () {
    Route::get('/', [HasilController::class, 'index'])->name('index');

    // PDF Semua
    Route::get('/pdf/view-all', [HasilController::class, 'viewAllPdf'])->name('pdf.viewAll');
    Route::get('/pdf/download-all', [HasilController::class, 'downloadAllPdf'])->name('pdf.downloadAll');

    // PDF per Peserta
    Route::get('/pdf/view/{id}', [HasilController::class, 'viewPdf'])->name('pdf.view');
    Route::get('/pdf/download/{id}', [HasilController::class, 'downloadPdf'])->name('pdf.download');
});

// Panduan
Route::view('/panduan', 'panduan')->name('panduan');

// Toggle Pendaftaran (dipanggil oleh AJAX)
Route::post('/admin/pendaftaran/toggle', [PendaftarController::class, 'togglePendaftaran']);


/*
|--------------------------------------------------------------------------
| 🔐 RUTE ADMIN (PERLU LOGIN)
|--------------------------------------------------------------------------
*/

// Auth - Login/Register Admin
Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
Route::post('/login', [AdminAuthController::class, 'postlogin']);
Route::get('/register', [AdminAuthController::class, 'register'])->name('register');
Route::post('/register', [AdminAuthController::class, 'store']);
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

// Rute Admin Terproteksi
Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminAuthController::class, 'index'])->name('dashboard');

    // Surat Pengajuan
    Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');

    // Pendaftar
    Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
        Route::get('/', [PendaftarController::class, 'index'])->name('index');
        Route::post('/list', [PendaftarController::class, 'list'])->name('list');
        Route::get('/detail/{id}', [PendaftarController::class, 'show'])->name('show');
    });

    // Jadwal Ujian
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/{jadwal}/edit', [JadwalController::class, 'edit'])->name('edit');
        Route::put('/{jadwal}', [JadwalController::class, 'update'])->name('update');

        // Sesi dan Room
        Route::get('/{id}/sesi', [SesiJadwalController::class, 'index'])->name('sesi.index');
        Route::post('/{id}/sesi', [SesiJadwalController::class, 'storeSesi'])->name('sesi.store');
        Route::post('/{id}/room', [SesiJadwalController::class, 'storeRoom'])->name('room.store');
        Route::post('/{id}/bagi-peserta', [SesiJadwalController::class, 'bagiPesertaKeSesiRoom'])->name('bagi-peserta');
    });

    // CRUD Sesi
    Route::prefix('sesi')->name('sesi.')->group(function () {
        Route::get('/{id}/edit', [SesiJadwalController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SesiJadwalController::class, 'update'])->name('update');
        Route::delete('/{id}', [SesiJadwalController::class, 'destroy'])->name('destroy');
    });

    // CRUD Room
    Route::prefix('room')->name('room.')->group(function () {
        Route::get('/{id}/edit', [SesiJadwalController::class, 'editRoom'])->name('edit');
        Route::put('/{id}', [SesiJadwalController::class, 'updateRoom'])->name('update');
        Route::delete('/{id}', [SesiJadwalController::class, 'destroyRoom'])->name('destroy');
    });

    // Pengumuman
    Route::prefix('pengumumans')->name('pengumuman.')->group(function () {
        Route::get('/', [ControllerPengumuman::class, 'index'])->name('index');
        Route::get('/create', [ControllerPengumuman::class, 'create'])->name('create');
        Route::post('/', [ControllerPengumuman::class, 'store'])->name('store');
        Route::delete('/{id}', [ControllerPengumuman::class, 'destroy'])->name('destroy');
        Route::post('/list', [ControllerPengumuman::class, 'list'])->name('list');
    });

    // Hasil Ujian Admin
    Route::prefix('hasil-ujian')->name('hasil-ujian.')->group(function () {
        Route::get('/', [AdminHasilController::class, 'index'])->name('index');
        Route::get('/import', [AdminHasilController::class, 'importForm'])->name('import.form');
        Route::post('/import', [AdminHasilController::class, 'import'])->name('import');
    });
});
