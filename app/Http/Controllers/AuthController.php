<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function pilihLogin()
    {
        return redirect()->route('login');
    }

    public function showLogin($role = null)
    {
        if ($role !== null) {
            abort_unless(in_array($role, ['admin', 'kasir'], true), 404);
        }

        return view('auth.login', ['role' => $role]);
    }

    public function login(Request $request, $role = null)
    {
        $validRole = $role && in_array($role, ['admin', 'kasir'], true) ? $role : null;

        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['nullable', 'in:admin,kasir'],
        ]);

        $selectedRole = $request->input('role', $validRole);

        $user = \App\Models\User::where('username', $request->username)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password salah.'],
            ]);
        }

        if (! $user->aktif) {
            throw ValidationException::withMessages([
                'username' => ['Akun ini sudah dinonaktifkan. Hubungi admin untuk mengaktifkan kembali.'],
            ]);
        }

        $userRole = in_array($user->role, ['admin', 'kasir'], true) ? $user->role : 'kasir';

        if ($selectedRole && $selectedRole !== $userRole) {
            throw ValidationException::withMessages([
                'username' => ['Akun ini tidak sesuai dengan role yang dipilih.'],
            ]);
        }

        $guard = $userRole;

        foreach (['admin', 'kasir'] as $item) {
            if ($item !== $guard) {
                Auth::guard($item)->logout();
            }
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended($guard === 'admin' ? route('admin.dashboard') : route('kasir.index'));
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    public function logout(Request $request, $role = null)
    {
        $guard = $role && in_array($role, ['admin', 'kasir'], true) ? $role : 'kasir';

        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
