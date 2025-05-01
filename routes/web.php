
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


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PengumumanController;
<<<<<<< HEAD
use App\Http\Controllers\ScheduleController;
=======
use App\Http\Controllers\RegistrasiController;
>>>>>>> 23f08a69c1df912a3a1cddd85bddbb796a5f689e

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

<<<<<<< HEAD
// route jadwal
Route::get('/schedule', function () {
    return view('schedule.index');
=======
// =====================
// 🔐 ROUTE KHUSUS ADMIN
// =====================
Route::prefix('admin')->group(function () {
    // Halaman awal admin (opsional)
    Route::get('/', [WelcomeController::class, 'index'])->name('admin.home');

    // Login Admin
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);

    // Logout Admin
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    // Reset Password (opsional)
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');

    // Dashboard admin (dengan middleware auth)
    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
>>>>>>> 23f08a69c1df912a3a1cddd85bddbb796a5f689e
});
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');