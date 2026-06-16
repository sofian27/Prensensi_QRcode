@extends('layouts.admin')

@section('content')
<section class="page-hero compact">
    <div>
        <span class="page-kicker">Attendance Log</span>
        <h2 class="page-title">Data Presensi Guru</h2>
        <p class="page-subtitle">Pantau histori masuk, pulang, status kehadiran, dan metode pencatatan presensi.</p>
    </div>
</section>
@include('admin.presensi.table')
{{ $presensis->links() }}
@endsection
