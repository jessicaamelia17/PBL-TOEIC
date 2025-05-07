<?php


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

use App\Http\Controllers\AdminAuthController as ControllersAdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PendaftarController;



// Halaman utama publik
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Jadwal & peserta publik
Route::get('/schedule', fn() => view('schedule.schedule'));
Route::get('/peserta', fn() => view('peserta.index'));

// Grup route untuk registrasi
Route::prefix('registrasi')->group(function () {
    Route::get('/', [RegistrasiController::class, 'create'])->name('registrasi.create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('registrasi.store');
    Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('registrasi.getProdi');
    Route::get('/check-nim/{nim}', [RegistrasiController::class, 'checkNIM'])->name('registrasi.checkNIM');
});

// route jadwal
Route::get('/schedule', function () {
    return view('schedule.index');
});
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

// route hasil
Route::get('/hasil-ujian', function () {
    return view('hasil-ujian.index');
});
Route::get('/hasil-ujian', [HasilController::class, 'index'])->name('hasil-ujian.index');

// =====================
// 🔐 ROUTE KHUSUS ADMIN
// =====================
// Route::prefix('admin')->group(function () {
//     // Halaman awal admin (opsional)
//     Route::get('/', [WelcomeController::class, 'index'])->name('admin.home');

//     // Login Admin
//     Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('/login', [LoginController::class, 'login']);

//     // Logout Admin
//     Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

//     // Reset Password (opsional)
//     Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

//     // Dashboard admin (dengan middleware auth)
// //     Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// // Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
// // Route::post('/pendaftar/list', [PendaftarController::class, 'list'])->name('pendaftar.list');

// });

 Route::get('login', [ControllersAdminAuthController::class, 'login'])->name('login');
    Route::post('login', [ControllersAdminAuthController::class, 'postlogin']);

    // Halaman registrasi admin dan proses registrasi
    Route::get('register', [ControllersAdminAuthController::class, 'register'])->name('register');
    Route::post('register', [ControllersAdminAuthController::class, 'store_admin']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

    Route::middleware(['auth'])->group(function () {
     Route::get('/', [WelcomeController::class, 'index']);
    });


// Route::prefix('admin')->name('admin.')->group(function () {
//     // Halaman login dan proses login
   

//     // Halaman dashboard admin
//     Route::get('/', function() {
//         return view('welcomeadmin'); // Halaman dashboard admin
//     })->middleware('auth')->name('/'); // Pastikan middleware auth untuk admin

//     // Halaman reset password admin
//     Route::get('password/reset', [ControllersAdminAuthController::class, 'showLinkRequestForm'])
//         ->name('password.request');
    
//     // Proses logout admin
//     Route::post('logout', [ControllersAdminAuthController::class, 'logout'])->name('logout');
// });

Route::get('/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.index');
Route::post('/pendaftar/list', [PendaftarController::class, 'list'])->name('pendaftar.list');

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');