<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $data['login'],
            'password' => $data['password'],
            'is_active' => true,
        ];

        if (! Auth::validate($credentials)) {
            return back()->withErrors(['login' => 'Username/email atau password tidak sesuai.'])->onlyInput('login');
        }

        $user = User::where($field, $data['login'])
            ->where('is_active', true)
            ->firstOrFail();

        if ($this->mustUseSingleSession($user) && $this->hasActiveSession($user)) {
            return back()->withErrors(['login' => 'Maaf akun ini sudah login.'])->onlyInput('login');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($this->mustUseSingleSession($user)) {
            $user->forceFill(['active_session_id' => $request->session()->getId()])->save();
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $sessionId = $request->session()->getId();

        if ($user && $this->mustUseSingleSession($user) && $user->active_session_id === $sessionId) {
            $user->forceFill(['active_session_id' => null])->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function mustUseSingleSession(User $user): bool
    {
        return in_array($user->role, ['admin', 'kepala_sekolah'], true);
    }

    private function hasActiveSession(User $user): bool
    {
        if (! $user->active_session_id) {
            return false;
        }

        if (config('session.driver') !== 'database') {
            return true;
        }

        $session = DB::table(config('session.table', 'sessions'))
            ->where('id', $user->active_session_id)
            ->first();

        if (! $session) {
            $user->forceFill(['active_session_id' => null])->save();

            return false;
        }

        $expiresAt = (int) $session->last_activity + ((int) config('session.lifetime', 120) * 60);
        if ($expiresAt < time()) {
            DB::table(config('session.table', 'sessions'))->where('id', $user->active_session_id)->delete();
            $user->forceFill(['active_session_id' => null])->save();

            return false;
        }

        return true;
    }
}
