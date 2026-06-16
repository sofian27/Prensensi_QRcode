@extends('layouts.guru')

@section('content')
<section class="page-hero">
    <div>
        <span class="page-kicker">Ruang Personal Guru</span>
        <h2 class="page-title">Status Presensi dan Pengajuan</h2>
        <p class="page-subtitle">Pantau kehadiran hari ini, siapkan pengajuan resmi, dan ikuti arahan terbaru dari kepala sekolah.</p>
    </div>
    <div class="hero-badge">@include('components.icon', ['name' => 'bell']) Terhubung</div>
</section>
<div class="stats">
    <div class="card stat-card">@include('components.icon', ['name' => 'clock'])<span>Status Hari Ini</span><strong>{{ $presensiHariIni?->status ?? 'Belum presensi' }}</strong></div>
    <div class="card stat-card">@include('components.icon', ['name' => 'send'])<span>Total Pengajuan</span><strong>{{ $jumlahPengajuan }}</strong></div>
</div>
@endsection
