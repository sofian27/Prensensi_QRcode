<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartu Guru - {{ $guru->nama }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="card-page">
    @empty($downloadMode)
        <div class="card-actions no-print">
            <a class="btn ghost" href="{{ route('admin.guru.index') }}">Kembali</a>
            <a class="btn secondary" href="{{ route('admin.guru.kartu.download', $guru) }}">Download</a>
            <button class="btn" type="button" onclick="window.print()">Cetak</button>
        </div>
    @endempty

    <main class="teacher-card">
        <header>
            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo SMK Islam Cipasung">
            <div>
                <span>SMK Islam Cipasung</span>
                <strong>Kartu Identitas Guru</strong>
            </div>
        </header>
        <section class="teacher-card-body">
            <div>
                <p>Nama Guru</p>
                <h1>{{ $guru->nama }}</h1>
                <dl>
                    <div><dt>NIP</dt><dd>{{ $guru->nip }}</dd></div>
                    <div><dt>Username</dt><dd>{{ $guru->user?->username ?? '-' }}</dd></div>
                    <div><dt>Mata Pelajaran</dt><dd>{{ $guru->mata_pelajaran ?? '-' }}</dd></div>
                    <div><dt>Status</dt><dd>{{ ucfirst($guru->status) }}</dd></div>
                </dl>
            </div>
            <div class="teacher-card-qr">
                {!! $qrSvg !!}
                <small>Scan di terminal presensi sekolah</small>
            </div>
        </section>
    </main>
</body>
</html>
