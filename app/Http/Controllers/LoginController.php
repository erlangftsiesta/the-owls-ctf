<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect ke homepage
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Cek apakah user login dengan opsi "remember me"
        $remember = $request->has('remember'); // default false

        // Coba login dengan kredensial dan opsi remember
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('homepage'));
        }

        // Jika gagal login, kembali dengan pesan error
        return back()->withErrors([
            'loginError' => 'Username atau password salah'
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        // Proses logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login
        return redirect()->route('login');
    }
}
