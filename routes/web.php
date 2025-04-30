<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [LandingController::class, 'index']);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;

// Halaman login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('login', [LoginController::class, 'login']);

// Route untuk request reset password
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Route::get('/register', [RegistrasiController::class, 'index'])->name('registrasi.index');

// Route::get('/register', [RegistrasiController::class, 'create'])->name('registrasi.create');
// Route::post('/register', [RegistrasiController::class, 'store'])->name('registrasi.store');

// Route AJAX untuk ambil Prodi berdasarkan Jurusan
// Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi']);

// Route Registrasi
Route::prefix('registrasi')->group(function () {
    Route::get('/', [RegistrasiController::class, 'create'])->name('registrasi.create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('registrasi.store');
    Route::get('/get-prodi/{idJurusan}', [RegistrasiController::class, 'getProdi'])->name('registrasi.getProdi');
});

Route::get('/schedule', function () {
    return view('schedule.schedule');
});