<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlagQuestions;
use App\Models\TheFlag; // Import model TheFlag
use Illuminate\Support\Str;

class FlagQuestionController extends Controller
{
    // ✅ Menampilkan list soal untuk admin
    public function index()
    {
        $questions = FlagQuestions::latest()->paginate(10);
        return view('admin.question_flag.index', compact('questions'));
    }

    // ✅ Menampilkan form tambah soal
    public function create()
    {
        return view('admin.question_flag.create');
    }

    // ✅ Menyimpan soal baru dan flag (jawaban)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|text',
            'the_flag' => 'required|string', // Validasi untuk flag (jawaban)
        ]);

        // Buat flag_id unik menggunakan UUID
        $flagId = Str::uuid();

        // Simpan soal ke FlagQuestions
        $question = FlagQuestions::create([
            'flag_id' => $flagId,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $request->attachment,
        ]);

        // Simpan flag (jawaban) ke TheFlag dengan flag_id yang sama
        TheFlag::create([
            'flag_id' => $flagId,
            'the_flag' => $request->the_flag, // Flag di sini adalah jawaban yang benar
        ]);

        return redirect()->route('admin.question_flag.index')->with('success', 'Soal dan flag berhasil ditambahkan.');
    }

    // ✅ Menampilkan soal ke user (tanpa data sensitif)
    public function show($id)
    {
        $question = FlagQuestions::findOrFail($id);
        return view('challenge.cryptography.show', compact('question'));
    }

    // ✅ Menampilkan form edit
    public function edit($id)
    {
        $question = FlagQuestions::findOrFail($id);
        return view('admin.question_flag.edit', compact('question'));
    }

    // ✅ Menyimpan update soal dan flag
    public function update(Request $request, $id)
    {
        $question = FlagQuestions::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|text',
            'the_flag' => 'required|string', // Validasi untuk flag (jawaban)
        ]);

        $question->title = $request->title;
        $question->description = $request->description;
        $question->attachment = $request->attachment;
        $question->save();

        // Update juga flag (jawaban) di tabel TheFlag
        $flag = TheFlag::where('flag_id', $question->flag_id)->first();
        if ($flag) {
            $flag->the_flag = $request->the_flag; // Update jawaban dengan nilai yang baru
            $flag->save();
        }

        return redirect()->route('admin.question_flag.index')->with('success', 'Soal dan flag berhasil diperbarui.');
    }

    // ✅ Hapus soal dan flag
    public function destroy($id)
    {
        $question = FlagQuestions::findOrFail($id);

        // Hapus flag terkait di tabel TheFlag
        TheFlag::where('flag_id', $question->flag_id)->delete();

        $question->delete();

        return redirect()->route('admin.question_flag.index')->with('success', 'Soal dan flag berhasil dihapus.');
    }
}
