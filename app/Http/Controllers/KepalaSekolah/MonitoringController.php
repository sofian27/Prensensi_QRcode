<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Presensi;
use Illuminate\Support\Collection;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('kepsek.monitoring.index', [
            'presensis' => $this->presensiSemuaGuruHariIni(),
        ]);
    }

    private function presensiSemuaGuruHariIni(): Collection
    {
        return Guru::where('status', 'aktif')
            ->with(['presensis' => fn ($query) => $query->whereDate('tanggal', today())])
            ->orderBy('nama')
            ->get()
            ->map(function (Guru $guru): Presensi {
                $presensi = $guru->presensis->first() ?: new Presensi([
                    'tanggal' => today(),
                    'status' => 'belum_presensi',
                ]);

                $presensi->setRelation('guru', $guru);

                return $presensi;
            });
    }
}
