@extends($layout)

@section('title', 'Profil Saya')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">My Profile</span>
        <h2 class="page-title">Profil {{ $roleLabel }}</h2>
        <p class="page-subtitle">Informasi akun dan identitas pengguna yang terhubung dengan sistem presensi SMK Islam Cipasung.</p>
    </div>
    <div class="hero-badge">@include('components.icon', ['name' => 'shield']) {{ $roleLabel }}</div>
</section>

<div class="profile-layout">
    <section class="card profile-summary">
        <div class="profile-avatar image-avatar">
            @if ($user->profilePhotoUrl())
                <img src="{{ $user->profilePhotoUrl() }}" alt="Foto {{ $user->guru?->nama ?? $user->name }}">
            @else
                {{ strtoupper(substr($user->guru?->nama ?? $user->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <span>{{ $roleLabel }}</span>
            <h3>{{ $user->guru?->nama ?? $user->name }}</h3>
            <p>{{ $user->email }}</p>
        </div>
    </section>

    <section class="card profile-card">
        <h3 class="compact-title">Informasi Akun</h3>
        <dl>
            <div><dt>Nama Akun</dt><dd>{{ $user->name }}</dd></div>
            <div><dt>Username</dt><dd>{{ $user->username ?? '-' }}</dd></div>
            <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
            <div><dt>Role</dt><dd>{{ $roleLabel }}</dd></div>
            <div><dt>Status Akun</dt><dd>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
        </dl>
    </section>

    @if ($user->guru)
        <section class="card profile-card">
            <h3 class="compact-title">Profil Guru</h3>
            <dl>
                <div><dt>NIP</dt><dd>{{ $user->guru->nip }}</dd></div>
                <div><dt>Nama Guru</dt><dd>{{ $user->guru->nama }}</dd></div>
                <div><dt>Mata Pelajaran</dt><dd>{{ $user->guru->mata_pelajaran ?? '-' }}</dd></div>
                <div><dt>No HP</dt><dd>{{ $user->guru->no_hp ?? '-' }}</dd></div>
                <div><dt>Alamat</dt><dd>{{ $user->guru->alamat ?? '-' }}</dd></div>
                <div><dt>Status Guru</dt><dd>{{ ucfirst($user->guru->status) }}</dd></div>
            </dl>
        </section>
    @else
        <section class="card">
            <p class="empty-state">Profil ini belum terhubung ke data guru karena akun digunakan untuk peran {{ strtolower($roleLabel) }}.</p>
        </section>
    @endif
</div>
@endsection
