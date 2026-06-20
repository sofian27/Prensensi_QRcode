@extends('layouts.admin')

@section('title', 'Scan Presensi')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Scanner Terminal</span>
        <h2 class="page-title">Presensi QR Acanlogic</h2>
        <p class="page-subtitle">Terminal pemindai kartu QR/Barcode USB HID Keyboard Mode untuk mencatat presensi guru secara otomatis.</p>
    </div>
    <span class="hero-badge">@include('components.icon', ['name' => 'scan']) USB HID Ready</span>
</section>

<div class="scan-grid" style="grid-template-columns: 1fr;">
    <section class="card scanner-card" style="max-width: 560px;">
        <div class="teacher-scan-display">
            <div class="scan-symbol">@include('components.icon', ['name' => 'scan'])</div>
            <span>Terminal Presensi Guru</span>
            <strong>Scanner Presensi Aktif</strong>
            <p>Halaman scanner publik digunakan oleh petugas piket atau admin di meja penerimaan. Klik tombol di bawah untuk membuka terminal scan.</p>
        </div>

        <div class="scanner-head" style="margin-top: 1rem;">
            @include('components.icon', ['name' => 'clock'])
            <div>
                <strong>Cara Penggunaan</strong>
                <span>Buka halaman scanner, arahkan alat Acanlogic ke kartu QR guru.</span>
            </div>
        </div>

        <div class="scan-help" style="margin: 1rem 0;">
            <span>Scanner menggunakan mode USB HID Keyboard. Presensi diproses otomatis saat scanner mengirim ENTER.</span>
            <span>Jam masuk normal sampai 07.30. Lebih dari itu dicatat dengan keterangan terlambat.</span>
            <span>Mode otomatis membaca jam server sekolah untuk menentukan masuk atau pulang.</span>
        </div>

        <a class="btn" href="{{ route('scan.index') }}" target="_blank" rel="noopener">
            @include('components.icon', ['name' => 'scan'])
            Buka Halaman Scanner
        </a>
    </section>
</div>
@endsection
