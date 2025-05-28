<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ControllerMahasiswa;
use App\Http\Controllers\Admin\ControllerPengumuman;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\SesiJadwalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\KuotaController;
use App\Http\Controllers\Admin\HasilUjianController as AdminHasilController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\PengajuanSuratController;


// =============================
// 🔓 RUTE PUBLIK (TIDAK PERLU LOGIN)
// =============================

//login & register mahasiswa
// 🏠 Halaman Login TOEIC
// 🏠 Landing Page (Bisa diakses oleh umum)
Route::get('/', [LandingController::class, 'index'])->name('landing');
//============================Route Mahasiswa ========================
// 🔑 Login (Bisa diakses oleh umum)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔐 Routes yang memerlukan login mahasiswa
Route::middleware('auth:web')->prefix('mahasiswa')->as('mahasiswa.')->group(function () {
    // // Profile utama mahasiswa
    Route::get('/profile', [MahasiswaController::class, 'index'])->name('profile');
    // Edit profile mahasiswa (form edit)
    Route::get('/profile/edit/{nim}', [MahasiswaController::class, 'edit'])->name('edit');
    // Update profile mahasiswa (proses update)
    Route::put('/profile/edit/{nim}', [MahasiswaController::class, 'update'])->name('update');
    Route::get('/reset-password/{nim}', [MahasiswaController::class, 'resetPasswordForm'])->name('resetPassword.form');
    Route::post('/reset-password/{nim}', [MahasiswaController::class, 'resetPassword'])->name('resetPassword');
    // 📝 Pengumuman (Hanya bisa diakses oleh pengguna yang login)
    Route::get('/get-prodi/{id_jurusan}', [MahasiswaController::class, 'getProdiByJurusan']);
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('show-pengumuman');

    // 📅 Jadwal & Pendaftar (Harus login)
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/pendaftar/{id}', [ScheduleController::class, 'pendaftar'])->name('schedule.pendaftar');

    // 📝 Registrasi peserta (Hanya bisa diakses oleh pengguna yang login)
    Route::prefix('registrasi')->name('registrasi.')->group(function () {
        Route::get('/', [RegistrasiController::class, 'create'])->name('create');
        Route::post('/', [RegistrasiController::class, 'store'])->name('store');
        Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('getProdi');
        Route::get('/check-nim/{nim}', [RegistrasiController::class, 'checkNIM'])->name('checkNIM');
    });
    Route::get('/surat', [PengajuanSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/create', [PengajuanSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [PengajuanSuratController::class, 'store'])->name('surat.store');
    Route::post('/surat/upload-sertifikat', [PengajuanSuratController::class, 'uploadSertifikat'])->name('surat.uploadSertifikat');
    Route::delete('/surat/hapus-sertifikat', [PengajuanSuratController::class, 'hapusSertifikat'])->name('surat.hapusSertifikat');

    // 🚪 Logout dari sistem TOEIC
    // Route::post('/logout-toeic', [AuthController::class, 'logout'])->name('logout-toeic');
});

//====================================================================================================

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

Route::get('/pengajuan', [PengajuanSuratController::class, 'index'])->name('surat.index');
Route::get('/pengajuan/create', [PengajuanSuratController::class, 'create'])->name('suratpengajuan.create');
Route::post('/pengajuan', [PengajuanSuratController::class, 'store'])->name('surat.pengajuan.store');
// Panduan
Route::view('/panduan', 'panduan')->name('panduan');

// Toggle Pendaftaran (dipanggil oleh AJAX)
Route::post('/admin/pendaftaran/toggle', [PendaftarController::class, 'togglePendaftaran']);


/*
|--------------------------------------------------------------------------
| 🔐 RUTE ADMIN (PERLU LOGIN)
|--------------------------------------------------------------------------
*/

Route::post('/admin/kuota/update', [AdminAuthController::class, 'updateKuota'])->name('admin.kuota.update');

// Rute Admin Terproteksi
Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminAuthController::class, 'index'])->name('dashboard');

    //kuota
    Route::post('/home', [KuotaController::class, 'update'])->name('dashboard');

    // Surat Pengajuan
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index'); // <== INI YANG HARUS ADA
        Route::post('/list', [SuratController::class, 'list'])->name('list');
        Route::get('/create_ajax', [SuratController::class, 'createAjax'])->name('create_ajax');
        Route::post('/store', [SuratController::class, 'store'])->name('store');
        Route::get('/{id}/edit_ajax', [SuratController::class, 'editAjax'])->name('edit_ajax');
        Route::put('/{id}', [SuratController::class, 'update'])->name('update');
        Route::delete('/{id}', [SuratController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/update_status', [SuratController::class, 'updateStatus'])->name('update_status'); // Untuk status verifikasi
    });


    // Pendaftar
    Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
        Route::get('/', [PendaftarController::class, 'index'])->name('index');
        Route::post('/list', [PendaftarController::class, 'list'])->name('list');
        Route::get('/detail/{id}', [PendaftarController::class, 'show'])->name('show');
    });

    // Rute Jadwal Ujian
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/{jadwal}/edit', [JadwalController::class, 'edit'])->name('edit');
        Route::put('/{jadwal}', [JadwalController::class, 'update'])->name('update');

        // Buat bagi peserta ke sesi dan room tetap di sini karena terkait jadwal, tetap di controller sesi
        Route::post('/{id}/bagi-peserta', [SesiJadwalController::class, 'bagiPesertaKeSesiRoom'])->name('bagi-peserta');
    });

    // CRUD Sesi (di SesiJadwalController)
    Route::prefix('sesi')->name('sesi.')->group(function () {
        Route::get('/{id}', [SesiJadwalController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [SesiJadwalController::class, 'edit'])->name('edit');
        Route::post('/{id}/store-sesi', [SesiJadwalController::class, 'storeSesi'])->name('storeSesi');
        Route::put('/{id}', [SesiJadwalController::class, 'update'])->name('update');
        Route::delete('/{id}', [SesiJadwalController::class, 'destroy'])->name('destroy');
    });

    // CRUD Room (pindah ke RoomController)
    Route::prefix('room')->name('room.')->group(function () {
        Route::get('/{id}/edit', [SesiJadwalController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SesiJadwalController::class, 'update'])->name('update');
        Route::delete('/{id}', [SesiJadwalController::class, 'destroy'])->name('destroy');
        Route::post('/store-room/{id_sesi}', [SesiJadwalController::class, 'storeRoom'])->name('storeRoom'); // Tambahan: jika ada tambah room
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

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/{id}', [SuratController::class, 'show'])->name('show'); // 👈 Tambahkan ini
        // ...
    });
    // Data Mahasiswa
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [ControllerMahasiswa::class, 'index'])->name('index');
        Route::get('/create', [ControllerMahasiswa::class, 'create'])->name('create');
        Route::post('/', [ControllerMahasiswa::class, 'store'])->name('store');
        Route::delete('/{nim}', [ControllerMahasiswa::class, 'destroy'])->name('destroy');
        Route::post('/list', [ControllerMahasiswa::class, 'list'])->name('list');
        Route::get('/get-prodi/{id_jurusan}', [ControllerMahasiswa::class, 'getProdiByJurusan'])->name('getProdi');
        Route::post('/import', [ControllerMahasiswa::class, 'import_ajax'])->name('import_ajax');
    });
    // Pengambilan Sertifikat
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    });
});
