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

@include('components.alert')

<div class="profile-layout profile-layout-refined">
    <div class="profile-info-stack">
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

    <div class="profile-form-stack">
        <form class="card profile-edit-form" method="post" action="{{ route($rolePrefix . '.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="compact-title">Edit Profil</h3>
            <p class="form-note">Beberapa kolom identitas utama (seperti NIP, Role, Status, dan Mata Pelajaran) dikunci dan hanya dapat diubah oleh Administrator.</p>

            <div class="profile-photo-editor">
                <div class="profile-avatar image-avatar">
                    @if ($user->profilePhotoUrl())
                        <img src="{{ $user->profilePhotoUrl() }}" alt="Foto {{ $user->guru?->nama ?? $user->name }}">
                    @else
                        {{ strtoupper(substr($user->guru?->nama ?? $user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <label>Foto Profil Baru</label>
                    <input type="file" name="profile_photo" accept="image/png,image/jpeg,image/webp">
                    <p class="field-hint">Format JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                    @error('profile_photo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label>Nama Tampilan Akun</label>
                    <input name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Username</label>
                    <input name="username" value="{{ old('username', $user->username) }}">
                    @error('username')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                @if ($user->guru)
                    <div>
                        <label>No HP</label>
                        <input name="no_hp" value="{{ old('no_hp', $user->guru->no_hp) }}">
                        @error('no_hp')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                @endif
            </div>
            
            @if ($user->guru)
                <div style="margin-top: 15px;">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat lengkap">{{ old('alamat', $user->guru->alamat) }}</textarea>
                    @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            @endif

            <div class="form-actions">
                <button class="btn" type="submit">@include('components.icon', ['name' => 'check']) Simpan Profil</button>
            </div>
        </form>

        <form class="card profile-password-card" method="post" action="{{ route($rolePrefix . '.profil.password') }}">
            @csrf
            @method('PUT')
            <h3 class="compact-title">Ubah Password</h3>
            <p class="form-note">Pastikan akun Anda menggunakan password yang kuat. Password baru minimal 8 karakter.</p>
            
            <div class="form-grid">
                <div>
                    <label>Password Saat Ini</label>
                    <input type="password" name="current_password" required>
                    @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Password Baru</label>
                    <input type="password" name="password" required minlength="8">
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required minlength="8">
                </div>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">@include('components.icon', ['name' => 'check']) Ubah Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
