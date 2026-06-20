<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DirektoriGuruController;
use App\Http\Controllers\Admin\GuruCardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\ProfilPenggunaController;
use App\Http\Controllers\Admin\ScanLauncherController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/guru/{guru}/kartu', [GuruCardController::class, 'show'])->name('guru.kartu.show');
    Route::get('/guru/{guru}/kartu/download', [GuruCardController::class, 'download'])->name('guru.kartu.download');
    Route::resource('guru', GuruController::class);
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');

    // Scanner launcher — no scan form, no directory table
    Route::get('/scan', [ScanLauncherController::class, 'index'])->name('scan.index');

    // Teacher directory — independent from scanner
    Route::get('/direktori-guru', [DirektoriGuruController::class, 'index'])->name('direktori_guru.index');
    Route::get('/direktori-guru/{user}/edit', [ProfilPenggunaController::class, 'edit'])->name('direktori_guru.edit');
    Route::put('/direktori-guru/{user}', [ProfilPenggunaController::class, 'update'])->name('direktori_guru.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/kirim', [LaporanController::class, 'kirim'])->name('laporan.kirim');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
});
