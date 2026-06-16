<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;

class PresensiController extends Controller
{
    public function index()
    {
        return view('admin.presensi.index', [
            'presensis' => Presensi::with('guru')->latest('tanggal')->paginate(15),
        ]);
    }
}
