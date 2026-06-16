<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanRequest;
use App\Models\Pengajuan;
use App\Services\NotificationService;

class PengajuanController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        return view('guru.pengajuan.index', [
            'pengajuans' => $guru ? Pengajuan::where('guru_id', $guru->id)->latest()->get() : collect(),
        ]);
    }

    public function store(StorePengajuanRequest $request, NotificationService $notificationService)
    {
        $guru = $request->user()->guru;
        abort_if(! $guru, 404, 'Profil guru belum terhubung.');

        $data = $request->validated();
        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('surat');
        }

        $pengajuan = $guru->pengajuans()->create($data);

        $notificationService->kirimKeRole(
            'kepala_sekolah',
            'Pengajuan '.ucwords(str_replace('_', ' ', $pengajuan->jenis)),
            $guru->nama.' mengirim pengajuan '.$pengajuan->jenis.' tanggal '.$pengajuan->tanggal_mulai->format('d-m-Y').' sampai '.$pengajuan->tanggal_selesai->format('d-m-Y').'.',
            'pengajuan'
        );

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}
