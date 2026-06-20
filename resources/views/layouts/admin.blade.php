<!doctype html>
<html lang="id">
<head>
    @php
        $pageTitle = View::hasSection('title') ? View::getSection('title') . ' — Presensi QR Acanlogic' : 'Admin Panel — Presensi QR Acanlogic';
    @endphp
    @include('components.seo', ['title' => $pageTitle])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="app-body">
    <div class="shell">
        @include('components.sidebar', ['role' => 'admin'])
        <main class="content">
            @include('components.navbar', ['title' => 'Command Center Admin', 'subtitle' => 'Operasional presensi, data guru, laporan, dan komunikasi sekolah'])
            @include('components.alert')
            @yield('content')
        </main>
    </div>
</body>
</html>
