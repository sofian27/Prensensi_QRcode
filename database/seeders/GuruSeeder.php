<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use App\Services\QRCodeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'guru@sma-cipasung.test'],
            [
                'name' => 'Guru Matematika',
                'username' => 'guru001',
                'password' => Hash::make('GURU-001'),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        $guru = Guru::updateOrCreate(
            ['nip' => 'GURU-001'],
            [
                'user_id' => $user->id,
                'nama' => 'Guru Matematika',
                'mata_pelajaran' => 'Matematika',
                'no_hp' => '081234567890',
                'alamat' => 'Tasikmalaya',
                'status' => 'aktif',
            ]
        );

        app(QRCodeService::class)->ensureGuruToken($guru);
    }
}
