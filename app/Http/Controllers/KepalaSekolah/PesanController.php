<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        return view('kepsek.pesan.index');
    }

    public function store(Request $request, NotificationService $notificationService)
    {
        $data = $request->validate([
            'tujuan' => ['required', 'in:admin,guru,semua'],
            'judul' => ['required', 'string', 'max:150'],
            'pesan' => ['required', 'string'],
        ]);

        $roles = $data['tujuan'] === 'semua'
            ? ['admin', 'guru']
            : [$data['tujuan']];

        $notificationService->kirimKeBanyakRole(
            $roles,
            'Pesan Kepsek: '.$data['judul'],
            $data['pesan'],
            'pesan_kepsek'
        );

        return back()->with('success', 'Pesan kepsek berhasil dikirim ke tujuan yang dipilih.');
    }
}
