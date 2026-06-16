<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('profile.index', compact('user', 'layout', 'roleLabel'));
    }
}
