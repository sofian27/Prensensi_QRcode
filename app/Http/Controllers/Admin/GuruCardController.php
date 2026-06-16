<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Services\QRCodeService;
use Illuminate\Http\Response;

class GuruCardController extends Controller
{
    public function show(Guru $guru, QRCodeService $qrCodeService)
    {
        return view('admin.guru.kartu', [
            'guru' => $guru->loadMissing('user'),
            'qrSvg' => $qrCodeService->guruSvg($guru),
        ]);
    }

    public function download(Guru $guru, QRCodeService $qrCodeService): Response
    {
        return response()
            ->view('admin.guru.kartu', [
                'guru' => $guru->loadMissing('user'),
                'qrSvg' => $qrCodeService->guruSvg($guru),
                'downloadMode' => true,
            ])
            ->header('Content-Disposition', 'attachment; filename="kartu-guru-'.$guru->nip.'.html"');
    }
}
