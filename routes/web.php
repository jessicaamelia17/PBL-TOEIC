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
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\KuotaController;
use App\Http\Controllers\Admin\HasilUjianController as AdminHasilController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RiwayatSeederController;


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

Route::get('locale/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');

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
    Route::get('/surat/cetak/{id}', [PengajuanSuratController::class, 'cetakSurat'])->name('surat.cetak');
    Route::get('/surat/preview/{id}', [PengajuanSuratController::class, 'preview'])->name('surat.preview');
    Route::post('/surat/upload-ulang', [PengajuanSuratController::class, 'uploadUlang'])->name('surat.uploadUlang');

// RiwayatPendaftar
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

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



Route::post('/go-back', function () {
    $history = session()->get('page_history', []);

    array_pop($history); // Buang halaman saat ini
    $previous = array_pop($history); // Ambil halaman sebelumnya

    session(['page_history' => $history]); // Simpan kembali history

    return $previous ? redirect($previous) : redirect('/');
})->name('go.back');

/*
|--------------------------------------------------------------------------
| 🔐 RUTE ADMIN (PERLU LOGIN)
|--------------------------------------------------------------------------
*/

Route::post('/admin/kuota/update', [AdminAuthController::class, 'updateKuota'])->name('admin.kuota.update');

// Rute Admin Terproteksi
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminAuthController::class, 'index'])->name('dashboard');
    Route::post('/home', [KuotaController::class, 'update'])->name('dashboard.post'); // kasih nama beda supaya gak bentrok
    Route::post('/home', [KuotaController::class, 'update'])->name('dashboard');
    Route::post('/kuota/update', [AdminAuthController::class, 'updateKuota'])->name('kuota.update');

    // Profil Admin
    Route::get('profile', [ProfileAdminController::class, 'show'])->name('profile');
    Route::get('profile/edit', [ProfileAdminController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileAdminController::class, 'update'])->name('profile.update');

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
        Route::get('/export', [PendaftarController::class, 'exportForm'])->name('export.form');
        Route::post('/export', [PendaftarController::class, 'export'])->name('export');
        Route::get('/import', [PendaftarController::class, 'importForm'])->name('import.form');
        Route::post('/import', [PendaftarController::class, 'import'])->name('import');
    });

    // Rute Jadwal Ujian
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'index'])->name('index');
        Route::get('/create', [JadwalController::class, 'create'])->name('create');
        Route::post('/', [JadwalController::class, 'store'])->name('store');
        Route::get('/{jadwal}/edit', [JadwalController::class, 'edit'])->name('edit');
        Route::put('/{jadwal}', [JadwalController::class, 'update'])->name('update');
        Route::delete('/{jadwal}', [JadwalController::class, 'destroy'])->name('destroy');
        Route::post('/list', [JadwalController::class, 'list'])->name('list'); // <-- Tambahkan ini
    });
    Route::prefix('sesi-jadwal')->name('sesi-jadwal.')->group(function () {
        Route::post('/{id}/bagi-peserta', [SesiJadwalController::class, 'bagiPesertaKeSesiRoom'])->name('bagiPeserta');
        Route::get('/{id_jadwal}/pembagian', [SesiJadwalController::class, 'pembagian'])->name('pembagian');
        Route::post('/{id}/reset', [SesiJadwalController::class, 'resetPembagian'])->name('reset');
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
        Route::get('/{id}/edit', [SesiJadwalController::class, 'editRoom'])->name('edit');
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
        Route::get('/edit/{id}', [ControllerPengumuman::class, 'edit'])->name('edit');
        Route::put('/{id}', [ControllerPengumuman::class, 'update'])->name('update');
    });

    // Hasil Ujian Admin
    Route::prefix('hasil-ujian')->name('hasil-ujian.')->group(function () {
        Route::get('/', [AdminHasilController::class, 'index'])->name('index');
        Route::get('/import', [AdminHasilController::class, 'importForm'])->name('import.form');
        Route::post('/import', [AdminHasilController::class, 'import'])->name('import');
        Route::get('/export-form', [AdminHasilController::class, 'exportForm'])->name('export.form');
        Route::get('/export', [AdminHasilController::class, 'export'])->name('export');
        Route::get('/export-pdf', [AdminHasilController::class, 'exportPdf'])->name('exportPdf');
    });

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/{id}', [SuratController::class, 'show'])->name('show');
        Route::post('/{id}/update_status', [SuratController::class, 'updateStatus'])->name('update_status');


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
    Route::prefix('sertifikat')->name('sertifikat.')->group(function () {
        Route::get('/', [SertifikatController::class, 'index'])->name('index');
        Route::put('/{id}', [SertifikatController::class, 'update'])->name('update');
        Route::get('/export', [SertifikatController::class, 'export'])->name('export');
        Route::get('/sync', [SertifikatController::class, 'syncSertifikat'])->name('sync');
        Route::put('/ambil/{id}', [SertifikatController::class, 'ambil'])->name('ambil');
        Route::get('/export/pdf', [SertifikatController::class, 'exportPdf'])->name('exportPdf');
    });
    // Manual jalankan pengisian riwayat pendaftar
    
});
//Route::get('/admin/riwayat/isi', [RiwayatSeederController::class, 'isiRiwayat'])->name('admin.riwayat.isi');


// Route::get('/sync-riwayat', [LandingController::class, 'syncRiwayat'])
//     ->middleware('auth') // agar hanya user login yang bisa akses
//     ->name('riwayat.sync');
