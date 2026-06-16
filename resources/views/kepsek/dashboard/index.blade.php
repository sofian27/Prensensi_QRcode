@extends('layouts.kepsek')

@section('content')
<section class="page-hero">
    <div>
        <span class="page-kicker">Executive Overview</span>
        <h2 class="page-title">Kendali Kehadiran dan Kebijakan</h2>
        <p class="page-subtitle">Lihat kondisi presensi, tindak lanjuti pengajuan, dan sampaikan arahan strategis kepada admin maupun guru.</p>
    </div>
    <div class="hero-badge">@include('components.icon', ['name' => 'shield']) Kepala Sekolah</div>
</section>
<div class="stats">
    <div class="card stat-card">@include('components.icon', ['name' => 'users'])<span>Guru Aktif</span><strong>{{ $totalGuruAktif }}</strong></div>
    <div class="card stat-card">@include('components.icon', ['name' => 'clock'])<span>Presensi Hari Ini</span><strong>{{ $presensiHariIni }}</strong></div>
    <div class="card stat-card">@include('components.icon', ['name' => 'check'])<span>Pengajuan Menunggu</span><strong>{{ $pengajuanMenunggu }}</strong></div>
</div>
@endsection
