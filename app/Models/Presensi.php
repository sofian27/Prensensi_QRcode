<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'metode_input',
        'kode_qr',
        'lokasi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
