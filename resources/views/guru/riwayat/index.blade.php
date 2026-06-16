@extends('layouts.guru')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Attendance History</span>
        <h2 class="page-title">Riwayat Presensi</h2>
        <p class="page-subtitle">Lihat catatan presensi Anda dari hari ke hari sebagai arsip kehadiran pribadi.</p>
    </div>
</section>
<table>
    <thead><tr><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Status</th></tr></thead>
    <tbody>
        @forelse ($presensis as $presensi)
            <tr><td>{{ $presensi->tanggal->format('d-m-Y') }}</td><td>{{ $presensi->jam_masuk ?? '-' }}</td><td>{{ $presensi->jam_pulang ?? '-' }}</td><td>{{ $presensi->status }}</td></tr>
        @empty
            <tr><td colspan="4">Riwayat presensi belum tersedia.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
