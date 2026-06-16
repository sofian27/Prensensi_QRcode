<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TerminalScanController extends Controller
{
    public function store(Request $request, PresensiService $presensiService)
    {
        if (! $request->filled('qr_code') && $request->filled('kode_qr')) {
            $request->merge(['qr_code' => $request->input('kode_qr')]);
        }

        $data = $request->validate([
            'qr_code' => ['required', 'string', 'max:500'],
            'jenis_scan' => ['required', 'in:otomatis,masuk,pulang'],
        ]);

        try {
            $presensi = $presensiService->absenDariKartu($this->extractToken($data['qr_code']), $data['jenis_scan']);
        } catch (ValidationException $exception) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $exception->validator->errors()->first('qr_code')
                        ?: $exception->validator->errors()->first('kode_qr'),
                ], 422);
            }

            return back()->withErrors($exception->errors());
        }

        $jenisScan = $presensi->getAttribute('jenis_scan_terpakai') ?: $data['jenis_scan'];

        $message = $jenisScan === 'pulang'
            ? $presensi->guru->nama.' berhasil scan pulang pukul '.$presensi->jam_pulang.'.'
            : $presensi->guru->nama.' berhasil scan masuk pukul '.$presensi->jam_masuk.'.';

        if ($presensi->keterangan) {
            $message .= ' '.$presensi->keterangan;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'speech' => $jenisScan === 'pulang'
                    ? 'Terima kasih Bapak dan Ibu. Presensi pulang berhasil.'
                    : 'Terima kasih Bapak atau Ibu. Presensi masuk berhasil.',
                'jenis_scan' => $jenisScan,
                'guru' => $presensi->guru->nama,
                'jam_masuk' => $presensi->jam_masuk,
                'jam_pulang' => $presensi->jam_pulang,
                'keterangan' => $presensi->keterangan,
            ]);
        }

        return back()->with('success', $message);
    }

    private function extractToken(string $value): string
    {
        $path = parse_url($value, PHP_URL_PATH);

        return trim($path ? basename($path) : $value);
    }
}
