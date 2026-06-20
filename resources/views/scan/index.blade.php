<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scanner Presensi — SMK Islam Cipasung</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="app-body">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div class="card scanner-card" style="max-width: 480px; width: 100%; text-align: center;">
            <div class="teacher-scan-display">
                <div class="scan-symbol">@include('components.icon', ['name' => 'scan'])</div>
                <span>Terminal Presensi</span>
                <strong>Scanner Publik</strong>
                <p>Halaman scanner publik sedang disiapkan. Silakan gunakan halaman scanner di panel admin untuk saat ini.</p>
            </div>

            <div class="scan-help" style="margin: 1.25rem 0; text-align: left;">
                <span>Halaman ini akan menjadi terminal scanner QR/Barcode mandiri tanpa perlu login admin.</span>
                <span>Implementasi penuh akan dilakukan pada tahap berikutnya.</span>
            </div>

            <a class="btn ghost" href="{{ url('/login') }}">
                @include('components.icon', ['name' => 'shield'])
                Masuk ke Panel Admin
            </a>
        </div>
    </div>
</body>
</html>
