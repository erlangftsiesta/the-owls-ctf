<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlagType;

class FlagTypeController extends Controller
{
    // ✅ Menampilkan list tipe flag untuk admin
    public function index()
    {
        $flagTypes = FlagType::latest()->paginate(10);
        return view('admin.flag_type.index', compact('flagTypes'));
    }

    // ✅ Menampilkan form tambah tipe flag
    public function create()
    {
        return view('admin.flag_type.create');
    }

    // ✅ Menyimpan tipe flag baru
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        FlagType::create([
            'type' => $request->type,
        ]);

        return redirect()->route('admin.flag_type.index')->with('success', 'Tipe flag berhasil ditambahkan.');
    }

    // ✅ Menampilkan form edit tipe flag
    public function edit($id)
    {
        $flagType = FlagType::findOrFail($id);
        return view('admin.flag_type.edit', compact('flagType'));
    }

    // ✅ Menyimpan update tipe flag
    public function update(Request $request, $id)
    {
        $flagType = FlagType::findOrFail($id);

        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $flagType->type = $request->type;
        $flagType->save();

        return redirect()->route('admin.flag_type.index')->with('success', 'Tipe flag berhasil diperbarui.');
    }

    // ✅ Menghapus tipe flag
    public function destroy($id)
    {
        $flagType = FlagType::findOrFail($id);
        $flagType->delete();

        return redirect()->route('admin.flag_type.index')->with('success', 'Tipe flag berhasil dihapus.');
    }
}
