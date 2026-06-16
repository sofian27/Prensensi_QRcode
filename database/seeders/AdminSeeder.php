<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sma-cipasung.test'],
            [
                'name' => 'Admin Presensi',
                'username' => 'admin',
                'password' => Hash::make('cipasung123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kepsek@sma-cipasung.test'],
            [
                'name' => 'Kepala Sekolah',
                'username' => 'kepsek',
                'password' => Hash::make('cipasung123'),
                'role' => 'kepala_sekolah',
                'is_active' => true,
            ]
        );
    }
}
