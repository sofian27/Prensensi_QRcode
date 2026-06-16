<?php

namespace App\Services;

use App\Models\Presensi;
use Illuminate\Support\Carbon;

class LaporanService
{
    public function rekapBulanan(?string $bulan = null)
    {
        $tanggal = $bulan ? Carbon::parse($bulan.'-01') : now();

        return Presensi::query()
            ->with('guru')
            ->whereBetween('tanggal', [
                $tanggal->copy()->startOfMonth()->toDateString(),
                $tanggal->copy()->endOfMonth()->toDateString(),
            ])
            ->latest('tanggal')
            ->get();
    }
}
