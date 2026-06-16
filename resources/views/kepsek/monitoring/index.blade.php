@extends('layouts.kepsek')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Live Monitoring</span>
        <h2 class="page-title">Monitoring Presensi Hari Ini</h2>
        <p class="page-subtitle">Pantau status kehadiran guru pada hari berjalan untuk pengambilan keputusan cepat.</p>
    </div>
</section>
@include('admin.presensi.table')
@endsection
