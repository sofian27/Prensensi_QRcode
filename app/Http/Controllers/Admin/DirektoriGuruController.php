<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DirektoriGuruController extends Controller
{
    public function index()
    {
        return view('admin.scan.index', [
            'users' => User::with('guru')
                ->whereIn('role', ['guru', 'kepala_sekolah'])
                ->orderByRaw("CASE WHEN role = 'kepala_sekolah' THEN 0 ELSE 1 END")
                ->orderBy('name')
                ->get(),
        ]);
    }
}
