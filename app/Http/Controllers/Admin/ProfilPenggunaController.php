<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilPenggunaController extends Controller
{
    public function edit(User $user)
    {
        abort_unless(in_array($user->role, ['guru', 'kepala_sekolah'], true), 404);

        return view('admin.scan.edit', [
            'user' => $user->loadMissing('guru'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_unless(in_array($user->role, ['guru', 'kepala_sekolah'], true), 404);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:100', 'alpha_dash', Rule::unique('users', 'username')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'is_active' => ['required', 'boolean'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($user->isGuru()) {
            $rules += [
                'nip' => ['required', 'string', 'max:50', Rule::unique('gurus', 'nip')->ignore($user->guru)],
                'mata_pelajaran' => ['nullable', 'string', 'max:255'],
                'no_hp' => ['nullable', 'string', 'max:30'],
                'alamat' => ['nullable', 'string'],
                'status' => ['required', 'in:aktif,nonaktif'],
            ];
        }

        $data = $request->validate($rules);

        DB::transaction(function () use ($request, $user, $data): void {
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $data['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
            }

            $user->update([
                'name' => $data['name'],
                'username' => $data['username'] ?? null,
                'email' => $data['email'],
                'is_active' => (bool) $data['is_active'],
                'profile_photo_path' => $data['profile_photo_path'] ?? $user->profile_photo_path,
            ]);

            if ($user->isGuru() && $user->guru) {
                $user->guru->update([
                    'nip' => $data['nip'],
                    'nama' => $data['name'],
                    'mata_pelajaran' => $data['mata_pelajaran'] ?? null,
                    'no_hp' => $data['no_hp'] ?? null,
                    'alamat' => $data['alamat'] ?? null,
                    'status' => $data['status'],
                ]);
            }
        });

        return redirect()->route('admin.scan.index')->with('success', 'Profil pengguna berhasil diperbarui.');
    }
}
