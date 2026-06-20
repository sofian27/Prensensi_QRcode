@extends('layouts.admin')

@section('title', 'Direktori Guru')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Direktori Kartu</span>
        <h2 class="page-title">Direktori Guru</h2>
        <p class="page-subtitle">Daftar kartu QR guru dan kepala sekolah yang terdaftar di sistem presensi.</p>
    </div>
    <span class="hero-badge">@include('components.icon', ['name' => 'users']) Kartu Aktif</span>
</section>

<section class="card">
    <h3 class="compact-title">Daftar Kartu Guru</h3>
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
                    <td><a class="btn ghost" href="{{ route('admin.direktori_guru.edit', $user) }}">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada data guru.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
