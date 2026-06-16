@extends('layouts.admin')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Scanner Terminal</span>
        <h2 class="page-title">Presensi QR Acanlogic</h2>
        <p class="page-subtitle">Gunakan scanner QR/Barcode USB HID Keyboard Mode. Input scanner akan tetap aktif dan presensi diproses otomatis saat scanner mengirim ENTER.</p>
    </div>
    <span class="hero-badge">@include('components.icon', ['name' => 'scan']) USB HID Ready</span>
</section>

<div class="scan-grid">
    <form class="card scanner-card scanner-terminal" method="post" action="{{ route('terminal.scan.store') }}" data-scanner-terminal data-endpoint="{{ route('terminal.scan.store') }}" data-status-id="admin-scan-status" data-mode-name="jenis_scan">
        @csrf
        <div class="teacher-scan-display">
            <div class="scan-symbol">@include('components.icon', ['name' => 'scan'])</div>
            <span>Terminal Presensi Guru</span>
            <strong>Silakan Scan Kartu QR</strong>
            <p>Admin memilih jenis presensi, guru cukup scan kartu menggunakan alat Acanlogic.</p>
        </div>

        <div class="scanner-head">
            @include('components.icon', ['name' => 'clock'])
            <div>
                <strong>Jenis Presensi</strong>
                <span>Mode otomatis membaca jam server sekolah.</span>
            </div>
        </div>

        <div class="scan-mode compact" aria-label="Pilih jenis presensi">
            <label><input type="radio" name="jenis_scan" value="otomatis" checked><span>Otomatis</span></label>
            <label><input type="radio" name="jenis_scan" value="masuk"><span>Scan Masuk</span></label>
            <label><input type="radio" name="jenis_scan" value="pulang"><span>Scan Pulang</span></label>
        </div>

        <label for="admin-scanner">Kode QR</label>
        <input type="text" id="admin-scanner" name="qr_code" autocomplete="off" autofocus data-scanner-input placeholder="Scan kartu QR di sini">

        <div id="admin-scan-status" class="scan-status">Scanner siap. Scan kartu QR guru.</div>
        <div class="scan-help">
            <span>Otomatis: jika sudah scan masuk dan waktu sudah siang/sore, scan berikutnya dicatat sebagai pulang.</span>
            <span>Jam masuk normal sampai 07.30. Lewat dari itu tetap tersimpan, dengan keterangan terlambat.</span>
        </div>
        <button class="btn" type="submit">@include('components.icon', ['name' => 'check']) Simpan Manual</button>
    </form>

    <section class="card">
        <h3 class="compact-title">Direktori Kartu Guru</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->guru?->nama ?? $user->name }}</td>
                        <td>{{ str_replace('_', ' ', $user->role) }}</td>
                        <td><span @class(['status-pill', 'status-empty' => $user->guru?->status !== 'aktif'])>{{ $user->guru?->status ?? '-' }}</span></td>
                        <td><a class="btn ghost" href="{{ route('admin.scan.edit', $user) }}">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>

<script src="{{ asset('assets/js/qr-terminal.js') }}"></script>
@endsection
