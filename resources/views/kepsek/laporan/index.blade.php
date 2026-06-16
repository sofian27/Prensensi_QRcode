@extends('layouts.kepsek')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Executive Report</span>
        <h2 class="page-title">Laporan Presensi</h2>
        <p class="page-subtitle">Baca laporan yang dikirim admin dan tinjau rekap presensi bulanan guru.</p>
    </div>
    <a class="btn" href="{{ route('kepsek.laporan.download', ['bulan' => request('bulan', now()->format('Y-m'))]) }}">
        @include('components.icon', ['name' => 'report']) Download Surat PDF
    </a>
</section>

<section class="notification-list">
    <h3 class="section-title">Laporan Masuk</h3>
    @forelse ($laporanMasuk as $laporan)
        <article class="notification-item">
            <div>
                <strong>{{ $laporan->judul }}</strong>
                <span>{{ $laporan->created_at->format('d-m-Y H:i') }}</span>
            </div>
            <p>{{ $laporan->pesan }}</p>
        </article>
    @empty
        <p class="empty-state">Belum ada laporan yang dikirim oleh admin.</p>
    @endforelse
</section>

<h3 class="section-title">Rekap Presensi</h3>
@include('admin.presensi.table')
@endsection
