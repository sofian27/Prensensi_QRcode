<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    public function kirim(User $user, string $judul, string $pesan, string $tipe = 'info'): Notifikasi
    {
        return Notifikasi::create([
            'user_id' => $user->id,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
        ]);
    }

    public function kirimKeRole(string $role, string $judul, string $pesan, string $tipe = 'info'): Collection
    {
        return User::where('role', $role)
            ->where('is_active', true)
            ->get()
            ->map(fn (User $user): Notifikasi => $this->kirim($user, $judul, $pesan, $tipe));
    }

    public function kirimKeBanyakRole(array $roles, string $judul, string $pesan, string $tipe = 'info'): Collection
    {
        return User::whereIn('role', $roles)
            ->where('is_active', true)
            ->get()
            ->map(fn (User $user): Notifikasi => $this->kirim($user, $judul, $pesan, $tipe));
    }
}
