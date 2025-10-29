<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form untuk meminta link reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Mengirim link reset password ke email pengguna.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kita akan menggunakan broker 'users' bawaan Laravel
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda!')
                    : back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
    }

    /**
     * Menampilkan form untuk mereset password.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Memproses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Password Anda telah berhasil direset!')
                    : back()->withErrors(['email' => 'Token reset password ini tidak valid.']);
    }
}
