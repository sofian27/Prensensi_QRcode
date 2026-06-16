@extends('layouts.admin')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Profil Guru</span>
        <h2 class="page-title">{{ $guru->nama }}</h2>
        <p class="page-subtitle">Detail identitas guru dan akses presensi berbasis QR.</p>
    </div>
</section>
<div class="card profile-card">
    <dl>
        <div><dt>NIP</dt><dd>{{ $guru->nip }}</dd></div>
        <div><dt>Username</dt><dd>{{ $guru->user?->username ?? '-' }}</dd></div>
        <div><dt>Password Awal</dt><dd>Mengikuti NIP guru</dd></div>
        <div><dt>Mata Pelajaran</dt><dd>{{ $guru->mata_pelajaran ?? '-' }}</dd></div>
        <div><dt>Status</dt><dd>{{ ucfirst($guru->status) }}</dd></div>
    </dl>
    <a class="btn" href="{{ route('admin.guru.kartu.show', $guru) }}">@include('components.icon', ['name' => 'card']) Cetak Kartu QR</a>
</div>
@endsection
