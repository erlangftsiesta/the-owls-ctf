<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::with('userType')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nama_lengkap' => 'required',
            'kelas' => 'required',
            'password' => 'required',
        ]);

        Users::create([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'kelas' => $request->kelas,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.index')
            ->with('success','Users created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $user)
    {
        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $user)
    {
        // Kembalikan view edit dengan data user
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $user)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'kelas' => 'required',
            'password' => 'required',
        ]);
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'kelas' => $request->kelas,
            'password' => $request->password,
        ]);

        return redirect()->route('user.index')
            ->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $user)
    {
        $user = Users::where('username', $user->username)->firstOrFail();
        $user->delete();
        return redirect()->route('user.index')
            ->with('success','User deleted successfully');
    }
}
