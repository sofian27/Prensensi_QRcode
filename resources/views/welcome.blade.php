<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SMK Islam Cipasung Presensi') }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="welcome-body">
    <header class="welcome-nav">
        <a class="brand" href="/">
            <img class="brand-logo" src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo SMK Islam Cipasung">
            <span>
                <strong>SMK Islam Cipasung</strong>
                <small>Yayasan Bpk. KH. H. Acep Adang Ruhiyat</small>
            </span>
        </a>
        <nav>
            <a href="#terminal">Terminal Scan</a>
            <a href="#alur">Workflow</a>
            <a href="#akses">Hak Akses</a>
            <a class="nav-login" href="{{ route('login') }}">Masuk</a>
        </nav>
    </header>

    <main class="welcome-main">
        <section class="landing-hero" id="tujuan">
            <div class="landing-copy">
                <span class="eyebrow">Smart Attendance Platform</span>
                <h1>Presensi Guru yang Cepat, Akurat, dan Terkelola.</h1>
                <p class="lead">Platform internal SMK Islam Cipasung untuk mencatat kehadiran berbasis QR, memproses pengajuan, dan menyajikan laporan siap tindak lanjut bagi pimpinan sekolah.</p>

                <div class="hero-actions">
                    <a class="btn" href="#terminal">@include('components.icon', ['name' => 'scan']) Buka Terminal</a>
                    <a class="btn ghost" href="#alur">@include('components.icon', ['name' => 'report']) Lihat Workflow</a>
                </div>

                <div class="purpose-list" aria-label="Tujuan sistem">
                    <div><strong>QR Attendance</strong><span>Pencatatan masuk dan pulang berlangsung real-time melalui kartu guru.</span></div>
                    <div>
                        <strong>Approval Flow</strong>
                        <span>Izin, sakit, cuti, dan dinas luar diproses dalam alur persetujuan yang jelas.</span>
                    </div>
                    <div>
                        <strong>Executive Report</strong>
                        <span>Rekap presensi dapat dikirim admin dan dibaca kepala sekolah secara ringkas.</span>
                    </div>
                </div>
            </div>

            <aside class="terminal-panel" id="terminal">
                <form class="terminal-manual scanner-terminal" method="post" action="{{ route('terminal.scan.store') }}" data-scanner-terminal data-endpoint="{{ route('terminal.scan.store') }}" data-status-id="scan-status" data-mode-name="jenis_scan">
                    @csrf
                    <div class="scanner-head">
                        @include('components.icon', ['name' => 'scan'])
                        <div>
                            <strong>Terminal Scanner QR</strong>
                            <span>Acanlogic USB HID Keyboard Mode</span>
                        </div>
                    </div>
                    <div class="scan-mode compact" aria-label="Pilih jenis presensi">
                        <label><input type="radio" name="jenis_scan" value="masuk" checked><span>Scan Masuk</span></label>
                        <label><input type="radio" name="jenis_scan" value="pulang"><span>Scan Pulang</span></label>
                    </div>
                    <label for="scanner">Input Scanner</label>
                    <input type="text" id="scanner" name="qr_code" autocomplete="off" autofocus data-scanner-input placeholder="Scan kartu QR guru">
                    <div id="scan-status" class="scan-status">Scanner siap. Scan kartu QR guru.</div>
                    <button class="btn" type="submit">@include('components.icon', ['name' => 'check']) Simpan Manual</button>
                </form>
            </aside>
        </section>

        <section class="workflow-section clear-flow" id="alur">
            <article class="workflow-card">
                <span>01</span>
                <strong>Profil Guru Tersentral</strong>
                <p>Admin mengelola data guru, akun akses, dan kartu QR dalam satu modul operasional.</p>
            </article>
            <article class="workflow-card">
                <span>02</span>
                <strong>Scan Masuk dan Pulang</strong>
                <p>Terminal membaca kartu guru, memvalidasi status pengajuan, lalu menyimpan presensi harian.</p>
            </article>
            <article class="workflow-card">
                <span>03</span>
                <strong>Monitoring Pimpinan</strong>
                <p>Kepala sekolah memantau presensi, memutuskan pengajuan, dan mengirim arahan resmi.</p>
            </article>
        </section>

        <section class="role-dashboard" id="akses">
            <div class="overview-head">
                <span class="eyebrow">Role-Based Experience</span>
                <h2>Setiap pengguna mendapat ruang kerja sesuai tanggung jawabnya.</h2>
            </div>

            <div class="role-map">
                <article>
                    <header><span>Admin</span><strong>Operasional Sekolah</strong></header>
                    <ul>
                        <li>Manajemen guru dan akun</li>
                        <li>Penerbitan kartu QR</li>
                        <li>Terminal presensi sekolah</li>
                        <li>Distribusi laporan ke kepsek</li>
                    </ul>
                </article>
                <article>
                    <header><span>Guru</span><strong>Self-Service Presensi</strong></header>
                    <ul>
                        <li>Melihat status presensi</li>
                        <li>Mengirim pengajuan resmi</li>
                        <li>Membaca arahan kepsek</li>
                    </ul>
                </article>
                <article>
                    <header><span>Kepala Sekolah</span><strong>Kontrol dan Keputusan</strong></header>
                    <ul>
                        <li>Monitoring presensi harian</li>
                        <li>Persetujuan pengajuan</li>
                        <li>Broadcast arahan ke admin/guru</li>
                    </ul>
                </article>
            </div>
        </section>
    </main>
    <script src="{{ asset('assets/js/qr-terminal.js') }}"></script>
</body>
</html>
