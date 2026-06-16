<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Pengajuan;
use App\Models\Presensi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'totalGuru' => Guru::count(),
            'presensiHariIni' => Presensi::whereDate('tanggal', today())->count(),
            'pengajuanMenunggu' => Pengajuan::where('status', 'menunggu')->count(),
        ]);
    }
}
