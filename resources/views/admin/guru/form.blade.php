@extends('layouts.admin')

@section('title', $guru->exists ? 'Edit Guru' : 'Tambah Guru')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Profil Guru</span>
        <h2 class="page-title">{{ $guru->exists ? 'Perbarui Data Guru' : 'Registrasi Guru Baru' }}</h2>
        <p class="page-subtitle">Pastikan data identitas, akun, dan status guru tersimpan rapi sebelum kartu QR diterbitkan.</p>
    </div>
</section>
<form class="card" method="post" action="{{ $guru->exists ? route('admin.guru.update', $guru) : route('admin.guru.store') }}">
    @csrf
    @if ($guru->exists) @method('PUT') @endif
    <div class="form-grid">
        <div><label>NIP</label><input name="nip" value="{{ old('nip', $guru->nip) }}" required></div>
        <div><label>Nama</label><input name="nama" value="{{ old('nama', $guru->nama) }}" required></div>
        <div><label>Username Login</label><input name="username" value="{{ old('username', $guru->user?->username) }}" required placeholder="contoh: guru001"></div>
        <div><label>Password Awal</label><input value="Otomatis mengikuti NIP guru" disabled></div>
        <div><label>Mata Pelajaran</label><input name="mata_pelajaran" value="{{ old('mata_pelajaran', $guru->mata_pelajaran) }}"></div>
        <div><label>No HP</label><input name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}"></div>
        <div><label>Status</label><select name="status"><option value="aktif">Aktif</option><option value="nonaktif" @selected(old('status', $guru->status) === 'nonaktif')>Nonaktif</option></select></div>
    </div>
    <label>Alamat Domisili</label><textarea name="alamat" placeholder="Alamat lengkap guru">{{ old('alamat', $guru->alamat) }}</textarea>
    <button class="btn" type="submit">@include('components.icon', ['name' => 'check']) Simpan Data Guru</button>
</form>
@endsection
