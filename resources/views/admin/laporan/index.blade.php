@extends('layouts.admin')

@section('content')
<div class="toolbar">
    <div>
        <span class="page-kicker">Monthly Report</span>
        <h2 class="page-title">Laporan Presensi</h2>
        <p class="page-subtitle">Susun ringkasan kehadiran bulanan dan kirimkan laporan kepada kepala sekolah.</p>
    </div>
</div>

<form class="card report-send-form" method="post" action="{{ route('admin.laporan.kirim') }}">
    @csrf
    <div class="form-grid">
        <div>
            <label>Bulan Laporan</label>
            <input type="month" name="bulan" value="{{ request('bulan', now()->format('Y-m')) }}">
        </div>
        <div>
            <label>Catatan Eksekutif</label>
            <input name="catatan" value="{{ old('catatan') }}" placeholder="Tambahkan konteks singkat untuk kepala sekolah">
        </div>
    </div>
    <button class="btn" type="submit">@include('components.icon', ['name' => 'send']) Kirim ke Kepala Sekolah</button>
</form>

@include('admin.presensi.table')
@endsection
