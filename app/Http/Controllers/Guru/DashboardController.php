<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Presensi;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        return view('guru.dashboard.index', [
            'presensiHariIni' => $guru ? Presensi::where('guru_id', $guru->id)->whereDate('tanggal', today())->first() : null,
            'jumlahPengajuan' => $guru ? Pengajuan::where('guru_id', $guru->id)->count() : 0,
        ]);
    }
}
