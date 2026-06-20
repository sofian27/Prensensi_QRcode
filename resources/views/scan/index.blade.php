<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scanner Presensi — SMK Islam Cipasung</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        /* ── Public scanner terminal — standalone layout ─────────────────── */
        .scan-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 28px 16px 48px;
        }

        /* Hero strip across the top */
        .scan-page-hero {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            width: 100%;
            max-width: 680px;
            border: 1px solid rgba(215, 222, 232, .9);
            border-radius: 8px;
            background:
                linear-gradient(135deg, rgba(255,255,255,.96), rgba(248,250,252,.92)),
                linear-gradient(90deg, rgba(15,118,110,.10), transparent);
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .06);
        }
        @media (max-width: 640px) {
            .scan-page-hero { flex-direction: column; }
        }

        /* The main terminal card */
        .scan-terminal-card {
            width: 100%;
            max-width: 680px;
        }

        /* Mode selector — 3 columns for 3 options */
        .scan-mode-3 {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            margin-bottom: 14px;
        }
        .scan-mode-3 label { cursor: pointer; }
        .scan-mode-3 input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: auto;
            margin: 0;
        }
        .scan-mode-3 span {
            display: grid;
            min-height: 44px;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: var(--primary-dark);
            font-weight: 900;
            text-align: center;
        }
        .scan-mode-3 input:checked + span {
            border-color: var(--primary);
            background: var(--primary);
            color: #fff;
            box-shadow: 0 10px 22px rgba(11, 107, 97, .18);
        }

        /* Result area */
        .scan-result {
            display: none;
            gap: 8px;
            border: 1px solid #b7d9d4;
            border-radius: 8px;
            background: linear-gradient(180deg, #f8fcfb, #e8f5f3);
            padding: 16px 18px;
        }
        .scan-result.visible { display: grid; }
        .scan-result-name {
            font-size: clamp(20px, 5vw, 28px);
            font-weight: 900;
            color: var(--primary-dark);
            line-height: 1.15;
        }
        .scan-result-meta {
            color: var(--muted);
            font-size: 14px;
            font-weight: 700;
        }
        .scan-result-type {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            padding: 5px 10px;
            font-size: 13px;
            font-weight: 900;
            width: max-content;
        }
        .scan-result-type.pulang {
            background: #b98a2a;
        }

        /* Fullscreen button */
        .fullscreen-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: #10283d;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: 800;
            font-size: 14px;
            white-space: nowrap;
            transition: background .16s ease, border-color .16s ease;
        }
        .fullscreen-btn:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
        }
        .fullscreen-btn .icon { flex-shrink: 0; }
        .fullscreen-btn[data-fs="on"] { border-color: var(--primary); color: var(--primary); }

        /* Bottom footer strip */
        .scan-page-footer {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 680px;
            gap: 12px;
        }
        .scan-page-footer a {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }
        .scan-page-footer a:hover { color: var(--primary); }
        .scan-clock {
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
        }

        /* Fullscreen mode — fill the screen */
        :fullscreen .scan-page,
        :-webkit-full-screen .scan-page {
            min-height: 100vh;
            padding-top: 40px;
        }
    </style>
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

        {{-- Scanner input (hidden visually but reachable by scanner hardware) --}}
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
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
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
