<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Presensi;

class RiwayatController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        return view('guru.riwayat.index', [
            'presensis' => $guru ? Presensi::where('guru_id', $guru->id)->latest('tanggal')->get() : collect(),
        ]);
    }
}
