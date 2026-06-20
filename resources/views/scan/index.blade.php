<!doctype html>
<html lang="id">
<head>
    @include('components.seo', [
        'title' => 'Scanner Presensi — Presensi QR Acanlogic',
        'description' => 'Terminal pemindaian QR untuk mencatat presensi guru secara otomatis menggunakan scanner USB HID.',
        'robots' => 'noindex, nofollow, noarchive'
    ])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="app-body">
<div class="scan-page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="scan-page-hero">
        <div>
            <span class="page-kicker">Scanner Terminal</span>
            <h1 class="page-title" style="margin: 10px 0 6px;">Presensi QR Acanlogic</h1>
            <p class="page-subtitle" style="margin: 0;">Gunakan scanner QR/Barcode USB HID Keyboard Mode. Input scanner akan tetap aktif dan presensi diproses otomatis saat scanner mengirim ENTER.</p>
        </div>
        <span class="hero-badge" id="fs-badge-hint">
            @include('components.icon', ['name' => 'scan']) USB HID Ready
        </span>
    </div>

    {{-- ── Terminal Card ─────────────────────────────────────────────── --}}
    <div class="card scanner-card scanner-terminal scan-terminal-card"
         data-scanner-terminal
         data-endpoint="{{ route('scan.store') }}"
         data-status-id="public-scan-status"
         data-mode-name="jenis_scan"
         data-result-id="public-scan-result">

        {{-- Teacher display area / result area --}}
        <div class="teacher-scan-display" id="scan-idle-display">
            <div class="scan-symbol">@include('components.icon', ['name' => 'scan'])</div>
            <span>Terminal Presensi Guru</span>
            <strong>Silakan Scan Kartu QR</strong>
            <p>Admin memilih jenis presensi, guru cukup scan kartu menggunakan alat Acanlogic.</p>
        </div>

        {{-- Scan result display (shown after each successful scan) --}}
        <div class="scan-result" id="public-scan-result" role="status" aria-live="polite">
            <div class="scan-result-type" id="scan-result-type">Masuk</div>
            <div class="scan-result-name" id="scan-result-name"></div>
            <div class="scan-result-meta" id="scan-result-meta"></div>
        </div>

        {{-- Mode selector --}}
        <div class="scanner-head">
            @include('components.icon', ['name' => 'clock'])
            <div>
                <strong>Jenis Presensi</strong>
                <span>Mode otomatis membaca jam server sekolah.</span>
            </div>
        </div>

        <div class="scan-mode-3" aria-label="Pilih jenis presensi">
            <label>
                <input type="radio" name="jenis_scan" value="otomatis" checked>
                <span>Otomatis</span>
            </label>
            <label>
                <input type="radio" name="jenis_scan" value="masuk">
                <span>Scan Masuk</span>
            </label>
            <label>
                <input type="radio" name="jenis_scan" value="pulang">
                <span>Scan Pulang</span>
            </label>
        </div>

        {{-- Scanner input --}}
        <label for="public-scanner">Kode QR</label>
        <input type="text"
               id="public-scanner"
               name="qr_code"
               autocomplete="off"
               autofocus
               data-scanner-input
               placeholder="Scan kartu QR di sini">

        {{-- Status box --}}
        <div id="public-scan-status" class="scan-status" role="status" aria-live="polite">Scanner siap. Scan kartu QR guru.</div>

        {{-- Help text --}}
        <div class="scan-help">
            <span>Otomatis: jika sudah scan masuk dan waktu sudah siang/sore, scan berikutnya dicatat sebagai pulang.</span>
            <span>Jam masuk normal sampai 07.30. Lewat dari itu tetap tersimpan, dengan keterangan terlambat.</span>
        </div>

        {{-- Action row --}}
        <div class="scan-actions">
            <button class="btn" type="button" id="btn-manual-submit" style="flex: 1;">
                @include('components.icon', ['name' => 'check']) Simpan Manual
            </button>
            <button class="fullscreen-btn" type="button" id="btn-fullscreen" title="Toggle fullscreen">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true" id="fs-icon-expand">
                    <path d="M7 14H5v5h5v-2H7v-3Zm-2-4h2V7h3V5H5v5Zm12 7h-3v2h5v-5h-2v3ZM14 5v2h3v3h2V5h-5Z"/>
                </svg>
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true" id="fs-icon-collapse" style="display:none;">
                    <path d="M5 16h3v3h2v-5H5v2Zm3-8H5v2h5V5H8v3Zm6 11h2v-3h3v-2h-5v5Zm2-11V5h-2v5h5V8h-3Z"/>
                </svg>
                <span id="fs-label">Fullscreen</span>
            </button>
        </div>
    </div>

    {{-- ── Footer ──────────────────────────────────────────────────────── --}}
    <div class="scan-page-footer">
        <span class="scan-clock" id="scan-clock"></span>
        <a href="{{ url('/login') }}">Panel Admin</a>
    </div>

</div>

<script src="{{ asset('assets/js/qr-terminal.js') }}"></script>
</body>
</html>

