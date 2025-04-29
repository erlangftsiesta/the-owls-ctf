<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'      => 'required|string|unique:users,username',
            'nama_lengkap'  => 'required|string|max:255',
            'kelas'         => 'required|string',
            'password'      => 'required|string|min:6|confirmed',
        ]);

        Users::create([
            'username'      => $validated['username'],
            'nama_lengkap'  => $validated['nama_lengkap'],
            'kelas'         => $validated['kelas'],
            'password'      => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
