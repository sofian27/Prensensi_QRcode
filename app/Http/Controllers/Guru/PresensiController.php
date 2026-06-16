<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;

class PresensiController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        return view('guru.presensi.index', [
            'guru' => $guru,
            'presensiHariIni' => $guru?->presensis()->whereDate('tanggal', today())->first(),
        ]);
    }
}
