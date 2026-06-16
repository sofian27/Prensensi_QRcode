<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Presensi Guru')</title>
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
