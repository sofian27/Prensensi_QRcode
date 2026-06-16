@extends('layouts.guru')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Leave Request</span>
        <h2 class="page-title">Pengajuan Kehadiran</h2>
        <p class="page-subtitle">Ajukan izin, sakit, cuti, atau dinas luar dengan rentang tanggal dan lampiran pendukung.</p>
    </div>
</section>
<form class="card" method="post" action="{{ route('guru.pengajuan.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-grid">
        <div><label>Jenis</label><select name="jenis"><option value="izin">Izin</option><option value="sakit">Sakit</option><option value="cuti">Cuti</option><option value="dinas_luar">Dinas Luar</option></select></div>
        <div><label>Lampiran</label><input type="file" name="lampiran"></div>
        <div><label>Tanggal Mulai</label><input type="date" name="tanggal_mulai" required></div>
        <div><label>Tanggal Selesai</label><input type="date" name="tanggal_selesai" required></div>
    </div>
    <label>Alasan Pengajuan</label><textarea name="alasan" required placeholder="Tuliskan alasan secara jelas dan singkat"></textarea>
    <button class="btn" type="submit">@include('components.icon', ['name' => 'send']) Kirim Pengajuan</button>
</form>
<h3 class="section-title">Riwayat Pengajuan</h3>
<table>
    <thead><tr><th>Jenis</th><th>Tanggal</th><th>Status</th></tr></thead>
    <tbody>
        @forelse ($pengajuans as $pengajuan)
            <tr><td>{{ $pengajuan->jenis }}</td><td>{{ $pengajuan->tanggal_mulai->format('d-m-Y') }} s.d. {{ $pengajuan->tanggal_selesai->format('d-m-Y') }}</td><td>{{ $pengajuan->status }}</td></tr>
        @empty
            <tr><td colspan="3">Belum ada pengajuan yang tercatat.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
