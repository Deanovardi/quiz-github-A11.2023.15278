<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;

use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\DokterController as AdminDokterController;
use App\Http\Controllers\Admin\PasienController as AdminPasienController;
use App\Http\Controllers\Admin\ObatController;

use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Dokter\RiwayatController;

use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\DaftarPoliController;
use App\Http\Controllers\Pasien\RiwayatPendaftaranController;

use App\Http\Controllers\Pasien\PembayaranController as PasienPembayaranController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;

use App\Models\Poli;
use App\Models\Obat;
use App\Models\User;
use App\Models\JadwalPeriksa;

// ================= ROOT =================
Route::get('/', function () {
    return view('auth.login');
});

// ================= AUTH =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->post('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->where('id', $id)->first();

    if ($notification) {
        $notification->markAsRead();
    }

    return back();
})->name('notifications.read');

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            \Carbon\Carbon::setLocale('id');

            return view('admin.dashboard', [
                'today'       => \Carbon\Carbon::now()->translatedFormat('l, d F Y'),
                'totalPoli'   => Poli::count(),
                'totalDokter' => User::where('role', 'dokter')->count(),
                'totalPasien' => User::where('role', 'pasien')->count(),
                'totalObat'   => Obat::count(),
                'polis'       => Poli::withCount('dokters')->latest('updated_at')->take(5)->get(),
            ]);
        })->name('dashboard');

       
        Route::get('/dokter/export', [ExportController::class, 'dokter'])->name('dokter.export');
        Route::get('/pasien/export', [ExportController::class, 'pasien'])->name('pasien.export');
        Route::get('/obat/export', [ExportController::class, 'obat'])->name('obat.export');

        Route::resource('polis', PoliController::class);
        Route::resource('dokter', AdminDokterController::class);
        Route::resource('pasien', AdminPasienController::class)->except(['show']);
        Route::resource('obat', ObatController::class);

        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/{id}/konfirmasi', [AdminPembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
        Route::post('/pembayaran/{id}/tolak', [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    });

// ================= DOKTER =================
Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {

        Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dashboard');

        
        Route::get('/jadwal-periksa/export', [ExportController::class, 'jadwalPeriksa'])->name('jadwal-periksa.export');
        Route::get('/riwayat-pasien/export', [ExportController::class, 'riwayatPasien'])->name('riwayat-pasien.export');

      
        Route::get('/jadwal-periksa', [JadwalPeriksaController::class, 'index'])->name('jadwal-periksa.index');
        Route::get('/jadwal-periksa/create', [JadwalPeriksaController::class, 'create'])->name('jadwal-periksa.create');
        Route::post('/jadwal-periksa', [JadwalPeriksaController::class, 'store'])->name('jadwal-periksa.store');
        Route::get('/jadwal-periksa/{id}/edit', [JadwalPeriksaController::class, 'edit'])->name('jadwal-periksa.edit');
        Route::put('/jadwal-periksa/{id}', [JadwalPeriksaController::class, 'update'])->name('jadwal-periksa.update');
        Route::delete('/jadwal-periksa/{id}', [JadwalPeriksaController::class, 'destroy'])->name('jadwal-periksa.destroy');

        
        Route::get('/periksa-pasien', [PeriksaController::class, 'index'])->name('periksa-pasien.index');
        Route::get('/periksa/{id}', [PeriksaController::class, 'create'])->name('periksa.create');
        Route::post('/periksa', [PeriksaController::class, 'store'])->name('periksa.store');

        Route::get('/riwayat-pasien', [RiwayatController::class, 'index'])->name('riwayat-pasien.index');
        Route::get('/riwayat-pasien/{id}', [RiwayatController::class, 'show'])->name('riwayat-pasien.show');
    });

// ================= PASIEN =================
Route::middleware(['auth', 'role:pasien'])
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {

        Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');

        Route::get('/daftar-poli', [DaftarPoliController::class, 'create'])->name('daftar-poli.create');
        Route::post('/daftar-poli', [DaftarPoliController::class, 'store'])->name('daftar-poli.store');

        Route::get('/riwayat-pendaftaran', [RiwayatPendaftaranController::class, 'index'])->name('riwayat-pendaftaran.index');
        Route::get('/riwayat-pendaftaran/{id}', [RiwayatPendaftaranController::class, 'show'])->name('riwayat-pendaftaran.show');

        Route::get('/pembayaran', [PasienPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/{id}/upload', [PasienPembayaranController::class, 'upload'])->name('pembayaran.upload');
    });

// ================= API STATUS ANTRIAN =================
Route::middleware(['auth'])->get('/api/antrian-status/{id}', function ($id) {
    $jadwal = JadwalPeriksa::find($id);

    return response()->json([
        'current_antrian' => $jadwal->current_antrian ?? 0,
    ]);
})->name('api.antrian-status');