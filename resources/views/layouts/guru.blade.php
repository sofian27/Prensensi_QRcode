<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Guru Presensi')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="app-body">
    <div class="shell">
        @include('components.sidebar', ['role' => 'guru'])
        <main class="content">
            @include('components.navbar', ['title' => 'Ruang Kerja Guru', 'subtitle' => 'Status presensi, pengajuan, riwayat, dan arahan kepala sekolah'])
            @include('components.alert')
            @yield('content')
        </main>
    </div>
</body>
</html>
