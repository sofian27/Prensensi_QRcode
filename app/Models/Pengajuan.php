<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'guru_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'lampiran',
        'status',
        'disetujui_oleh',
        'diproses_pada',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'diproses_pada' => 'datetime',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
