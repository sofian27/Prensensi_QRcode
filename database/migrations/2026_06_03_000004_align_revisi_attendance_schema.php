<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('gurus', 'token_qr')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->string('token_qr', 100)->nullable()->unique()->after('status');
            });
        }

        if (! Schema::hasColumn('presensis', 'metode_input')) {
            Schema::table('presensis', function (Blueprint $table) {
                $table->string('metode_input')->default('Scan Alat')->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('presensis', 'metode_input')) {
            Schema::table('presensis', function (Blueprint $table) {
                $table->dropColumn('metode_input');
            });
        }

        if (Schema::hasColumn('gurus', 'token_qr')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->dropUnique(['token_qr']);
                $table->dropColumn('token_qr');
            });
        }
    }
};
