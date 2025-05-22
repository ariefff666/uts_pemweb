<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // General dashboard after login
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\AbsensiController as DosenAbsensiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\RiwayatAbsensiController;

Route::get('/', function () {
    return view('welcome'); // Atau redirect ke login
});

// General dashboard, akan redirect berdasarkan role di controller
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Dosen Routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/', [DosenDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
    Route::get('/absensi', [DosenAbsensiController::class, 'index'])->name('absensi.index'); // Pilih matakuliah & tanggal
    Route::get('/absensi/manage/{matakuliah_id_mk}/{tanggal}', [DosenAbsensiController::class, 'manageAbsensi'])->name('absensi.manage'); // Form input absensi
    Route::post('/absensi/store', [DosenAbsensiController::class, 'storeAbsensi'])->name('absensi.store');
    Route::get('/absensi/report/{matakuliah_id_mk}', [DosenAbsensiController::class, 'showReport'])->name('absensi.report'); // Laporan absensi per matkul
    Route::get('/absensi/export/{matakuliah_id_mk}', [DosenAbsensiController::class, 'exportExcel'])->name('absensi.export'); // Fitur bonus
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-absensi', [RiwayatAbsensiController::class, 'index'])->name('riwayat.index');
});


require __DIR__.'/auth.php';