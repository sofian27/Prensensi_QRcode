<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE presensis MODIFY status ENUM('belum_presensi','hadir','izin','sakit','cuti','dinas_luar','alpa','alfa') NOT NULL DEFAULT 'hadir'");
        DB::statement("ALTER TABLE pengajuans MODIFY jenis ENUM('izin','sakit','cuti','dinas_luar') NOT NULL");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE presensis MODIFY status ENUM('hadir','izin','sakit','alpa') NOT NULL DEFAULT 'hadir'");
        DB::statement("ALTER TABLE pengajuans MODIFY jenis ENUM('izin','sakit','cuti') NOT NULL");
    }
};
