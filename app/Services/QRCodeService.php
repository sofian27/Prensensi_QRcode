<?php

namespace App\Services;

use App\Models\Guru;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Generator;

class QRCodeService
{
    public function ensureGuruToken(Guru $guru): string
    {
        if ($guru->token_qr) {
            return $guru->token_qr;
        }

        do {
            $token = 'GURU-'.Str::upper(Str::random(48));
        } while (Guru::where('token_qr', $token)->exists());

        $guru->forceFill(['token_qr' => $token])->save();

        return $token;
    }

    public function guruPayload(Guru $guru): string
    {
        return $this->ensureGuruToken($guru);
    }

    public function guruSvg(Guru $guru): string
    {
        return app(Generator::class)
            ->format('svg')
            ->size(260)
            ->margin(2)
            ->errorCorrection('M')
            ->generate($this->guruPayload($guru));
    }
}
