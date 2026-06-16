@extends('layouts.admin')

@section('title', 'Command Center Admin')

@section('content')
<section class="page-hero">
    <div>
        <span class="page-kicker">Panel Operasional</span>
        <h2 class="page-title">Command Center Administrasi</h2>
        <p class="page-subtitle">Kelola data guru, pantau presensi harian, dan kirim laporan resmi ke kepala sekolah dari satu ruang kerja.</p>
    </div>
    <div class="hero-badge">@include('components.icon', ['name' => 'shield']) Administrasi Aktif</div>
</section>
<div class="stats">
    <div class="card stat-card">@include('components.icon', ['name' => 'users'])<span>Guru Terdaftar</span><strong>{{ $totalGuru }}</strong></div>
    <div class="card stat-card">@include('components.icon', ['name' => 'clock'])<span>Presensi Hari Ini</span><strong>{{ $presensiHariIni }}</strong></div>
    <div class="card stat-card">@include('components.icon', ['name' => 'send'])<span>Pengajuan Menunggu</span><strong>{{ $pengajuanMenunggu }}</strong></div>
</div>
@endsection
