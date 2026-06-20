<?php

namespace App\Http\Controllers;

use App\Services\PresensiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function store(Request $request, PresensiService $presensiService)
    {
        // Force JSON negotiation so Laravel never renders an HTML error page
        // that could echo back the raw qr_code value.
        $request->headers->set('Accept', 'application/json');

        // Normalise field name: accept both 'qr_code' and 'kode_qr'
        if (! $request->filled('qr_code') && $request->filled('kode_qr')) {
            $request->merge(['qr_code' => $request->input('kode_qr')]);
        }

        $data = $request->validate([
            'qr_code'   => ['required', 'string', 'max:255'],
            'jenis_scan' => ['required', 'in:otomatis,masuk,pulang'],
        ]);

        try {
            $presensi = $presensiService->absenDariKartu(
                $this->extractToken($data['qr_code']),
                $data['jenis_scan']
            );
        } catch (ValidationException $exception) {
            $errorMessage = $exception->validator->errors()->first('qr_code')
                ?: $exception->validator->errors()->first('kode_qr')
                ?: 'Kartu QR tidak valid.';

            return response()->json([
                'message' => $errorMessage,
            ], 422);
        } catch (\Throwable $e) {
            // Log server-side only — never include the raw QR token.
            Log::error('ScanController: unexpected error during public scan', [
                'exception' => $e->getMessage(),
                'file'      => $e->getFile().':'.$e->getLine(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan pada server. Hubungi administrator.',
            ], 500);
        }

        $jenisScan = $presensi->getAttribute('jenis_scan_terpakai') ?: $data['jenis_scan'];

        $message = $jenisScan === 'pulang'
            ? $presensi->guru->nama.' berhasil scan pulang pukul '.$presensi->jam_pulang.'.'
            : $presensi->guru->nama.' berhasil scan masuk pukul '.$presensi->jam_masuk.'.';

        if ($presensi->keterangan) {
            $message .= ' '.$presensi->keterangan;
        }

        return response()->json([
            'message'    => $message,
            'speech'     => $jenisScan === 'pulang'
                ? 'Terima kasih Bapak dan Ibu. Presensi pulang berhasil.'
                : 'Terima kasih Bapak atau Ibu. Presensi masuk berhasil.',
            'jenis_scan' => $jenisScan,
            'guru'       => $presensi->guru->nama,
            'jam_masuk'  => $presensi->jam_masuk,
            'jam_pulang' => $presensi->jam_pulang,
        ]);
    }

    private function extractToken(string $value): string
    {
        $path = parse_url($value, PHP_URL_PATH);

        return trim($path ? basename($path) : $value);
    }
}
