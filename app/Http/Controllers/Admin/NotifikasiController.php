<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = auth()->user()
            ->notifikasis()
            ->latest()
            ->get();

        auth()->user()
            ->notifikasis()
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);

        return view('admin.notifikasi.index', compact('notifikasis'));
    }
}
