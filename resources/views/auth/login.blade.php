<!doctype html>
<html lang="id">

<head>
    @include('components.seo', [
        'title' => 'Login — Presensi QR Acanlogic',
        'description' => 'Halaman masuk sistem presensi guru berbasis QR Code untuk SMK Islam Cipasung.',
        'robots' => 'noindex, nofollow, noarchive',
        'type' => 'website'
    ])
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

<body class="login-body">
    <main class="login-page">
        <section class="login-visual">
            <img src="{{ asset('assets/images/1.jpeg') }}" alt="Banner Sistem Presensi Guru SMK Islam Cipasung">
            <div>
                <span>SMK Islam Cipasung</span>
                <h1>Masuk ke Platform Presensi Terpadu</h1>
                <p>Akses dashboard sesuai peran untuk mengelola presensi, pengajuan, laporan, dan arahan sekolah.</p>
            </div>
        </section>

        <section class="login-card">
            <a class="brand" href="/">
                <img class="brand-logo" src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo SMK Islam Cipasung">
                <span>
                    <strong>SMK Islam Cipasung</strong>
                    <small>Yayasan Bpk. KH. H. Acep Adang Ruhiyat</small>
                </span>
            </a>

            <h1>Selamat Datang</h1>
            <p>Gunakan kredensial resmi yang diberikan sekolah. Sistem akan mengarahkan Anda ke ruang kerja sesuai hak
                akses.</p>

            @include('components.alert')

            <form method="post" action="{{ route('login.store') }}">
                @csrf
                <label>Username atau Email</label>
                <input name="login" value="{{ old('login') }}" required autofocus
                    placeholder="contoh: admin atau guru001">

                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password akun">

                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat sesi masuk</span>
                </label>

                <button class="btn" type="submit">@include('components.icon', ['name' => 'shield']) Masuk ke Dashboard</button>
            </form>
        </section>
    </main>
</body>

</html>
