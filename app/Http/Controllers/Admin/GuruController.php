<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\User;
use App\Services\QRCodeService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        return view('admin.guru.index', [
            'gurus' => Guru::with('user')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.guru.form', ['guru' => new Guru()]);
    }

    public function store(StoreGuruRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['nama'],
                'username' => $data['username'],
                'email' => $this->emailFromUsername($data['username']),
                'password' => $data['nip'],
                'role' => 'guru',
                'is_active' => $data['status'] === 'aktif',
            ]);

            $guru = Guru::create([
                ...Arr::except($data, ['username']),
                'user_id' => $user->id,
            ]);

            app(QRCodeService::class)->ensureGuruToken($guru);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru dan akun login berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.form', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        DB::transaction(function () use ($request, $guru): void {
            $data = $request->validated();

            $user = $guru->user ?: User::create([
                'name' => $data['nama'],
                'username' => $data['username'],
                'email' => $this->emailFromUsername($data['username']),
                'password' => $data['nip'],
                'role' => 'guru',
                'is_active' => $data['status'] === 'aktif',
            ]);

            $userData = [
                'name' => $data['nama'],
                'username' => $data['username'],
                'email' => $this->emailFromUsername($data['username']),
                'password' => $data['nip'],
                'role' => 'guru',
                'is_active' => $data['status'] === 'aktif',
            ];

            $user->update($userData);

            $guru->update([
                ...Arr::except($data, ['username']),
                'user_id' => $user->id,
            ]);

            app(QRCodeService::class)->ensureGuruToken($guru);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru): void {
            $user = $guru->user;

            $guru->delete();
            $user?->delete();
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function emailFromUsername(string $username): string
    {
        return strtolower($username).'@sma-cipasung.local';
    }
}
