<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request, LaporanService $laporanService)
    {
        return view('admin.laporan.index', [
            'presensis' => $laporanService->rekapBulanan($request->query('bulan')),
        ]);
    }

    public function kirim(Request $request, LaporanService $laporanService, NotificationService $notificationService)
    {
        $data = $request->validate([
            'bulan' => ['nullable', 'date_format:Y-m'],
            'catatan' => ['nullable', 'string'],
        ]);

        $bulan = $data['bulan'] ?? now()->format('Y-m');
        $presensis = $laporanService->rekapBulanan($bulan);
        $hadir = $presensis->where('status', 'hadir')->count();
        $pulang = $presensis->whereNotNull('jam_pulang')->count();
        $cuti = $presensis->where('status', 'cuti')->count();

        $pesan = "Admin mengirim laporan presensi bulan {$bulan}. Ringkasan: {$hadir} hadir, {$pulang} sudah presensi pulang, {$cuti} cuti.";
        if (! empty($data['catatan'])) {
            $pesan .= ' Catatan admin: '.$data['catatan'];
        }

        $notificationService->kirimKeRole(
            'kepala_sekolah',
            'Laporan Presensi dari Admin',
            $pesan,
            'laporan_presensi'
        );

        return back()->with('success', 'Laporan presensi berhasil dikirim ke kepala sekolah.');
    }
}
