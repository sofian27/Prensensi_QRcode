<?php

use App\Http\Controllers\KepalaSekolah\DashboardController;
use App\Http\Controllers\KepalaSekolah\LaporanController;
use App\Http\Controllers\KepalaSekolah\MonitoringController;
use App\Http\Controllers\KepalaSekolah\PesanController;
use App\Http\Controllers\KepalaSekolah\PersetujuanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('kepsek')->name('kepsek.')->middleware(['auth', 'kepsek'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::post('/persetujuan/{pengajuan}/setujui', [PersetujuanController::class, 'setujui'])->name('persetujuan.setujui');
    Route::post('/persetujuan/{pengajuan}/tolak', [PersetujuanController::class, 'tolak'])->name('persetujuan.tolak');
    Route::get('/persetujuan/{pengajuan}/lampiran', [PersetujuanController::class, 'lampiran'])->name('persetujuan.lampiran');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download', [LaporanController::class, 'download'])->name('laporan.download');
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.password');
});
