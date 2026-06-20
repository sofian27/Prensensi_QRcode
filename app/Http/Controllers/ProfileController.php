<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->loadMissing('guru');

        $layout = match ($user->role) {
            'admin' => 'layouts.admin',
            'kepala_sekolah' => 'layouts.kepsek',
            default => 'layouts.guru',
        };

        $roleLabel = match ($user->role) {
            'admin' => 'Administrator',
            'kepala_sekolah' => 'Kepala Sekolah',
            default => 'Guru',
        };

        $rolePrefix = match ($user->role) {
            'admin' => 'admin',
            'kepala_sekolah' => 'kepsek',
            default => 'guru',
        };

        return view('profile.index', compact('user', 'layout', 'roleLabel', 'rolePrefix'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($user->guru) {
            $rules['no_hp'] = ['nullable', 'string', 'max:255'];
            $rules['alamat'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($user, $validated, $request) {
            $user->name = $validated['name'];
            if (array_key_exists('username', $validated)) {
                $user->username = $validated['username'];
            }
            $user->email = $validated['email'];

            if ($request->hasFile('profile_photo')) {
                $oldPhoto = $user->profile_photo_path;
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;

                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $user->save();

            if ($user->guru) {
                if (array_key_exists('no_hp', $validated)) {
                    $user->guru->no_hp = $validated['no_hp'];
                }
                if (array_key_exists('alamat', $validated)) {
                    $user->guru->alamat = $validated['alamat'];
                }
                $user->guru->save();
            }
        });

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
