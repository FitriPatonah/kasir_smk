<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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

        foreach (['admin', 'kasir'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return view('auth.confirm-logout', [
                    'dashboardUrl' => $guard === 'admin' ? route('admin.dashboard') : route('kasir.index'),
                    'logoutUrl' => route('auth.logout', ['role' => $guard]),
                ]);
            }
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

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

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
            'id' => $user->id,
            'password' => $request->password,
        ];

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard($guard)->user();
            session()->flash('welcome_toast', "Selamat datang, {$user->name}!");

            return redirect()->intended($guard === 'admin' ? route('admin.dashboard') : route('kasir.index'));
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Jika email terdaftar, tautan reset password akan dikirim.');
        }

        if ($status === Password::RESET_THROTTLED) {
            throw ValidationException::withMessages([
                'email' => ['Tunggu sebentar sebelum meminta tautan reset password lagi.'],
            ]);
        }

        return back()->with('status', 'Jika email terdaftar, tautan reset password akan dikirim.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan masuk dengan password baru.');
        }

        throw ValidationException::withMessages([
            'email' => ['Tautan reset password tidak valid atau sudah kedaluwarsa.'],
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
