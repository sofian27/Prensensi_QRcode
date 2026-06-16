<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TerminalScanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('dashboard');
});

Route::post('/terminal-scan', [TerminalScanController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('terminal.scan.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    $user = request()->user();

    return match ($user?->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'kepala_sekolah' => redirect()->route('kepsek.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        default => redirect('/'),
    };
})->middleware('auth')->name('dashboard');
