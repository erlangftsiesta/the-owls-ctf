<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlagQuestions;
use App\Models\UserAnswers;
use App\Models\TheFlag; // Import model TheFlag
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
            'attachment' => 'nullable|file',
            'type' => 'required|string',
            'the_flag' => 'required|string', // Validasi untuk flag (jawaban)
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('lampiran', 'public'); // ← ini WAJIB agar file pindah dari tmp ke storage
            $data['attachment'] = $path; // ← simpan path ke DB
        }
        // Buat flag_id unik menggunakan UUID
        $flagId = Str::uuid();

        // Simpan soal ke FlagQuestions
        $question = FlagQuestions::create([
            'flag_id' => $flagId,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'attachment' => $data['attachment'] ?? null,
        ]);

        // Simpan flag (jawaban) ke TheFlag dengan flag_id yang sama
        TheFlag::create([
            'flag_id' => $flagId,
            'the_flag' => $request->the_flag, // Flag di sini adalah jawaban yang benar
        ]);

        return redirect()->route('admin.question_flag.index')->with('success', 'Soal dan flag berhasil ditambahkan.');
    }

    // Perbaikan: menambahkan $type ke compact dan mengirim data completedChallenges
    public function listByType($type)
    {
        // Validasi tipe yang diizinkan
        $allowedTypes = ['cryptography', 'web-exploitation'];
        if (!in_array($type, $allowedTypes)) {
            abort(404); // atau redirect ke halaman lain
        }

        $questions = FlagQuestions::where('type', $type)->get(); // Pastikan kamu punya kolom 'type' di tabel
        
        // Get completed challenges for current user
        $completedChallenges = [];
        if (Auth::check()) {
            $completedChallenges = UserAnswers::where('username', Auth::user()->username)
                ->where('status', 1) // Only get successful submissions
                ->pluck('flag_id')
                ->toArray();
        }
        
        return view("challenge.$type.index", compact('questions', 'type', 'completedChallenges'));
    }

    public function show($type, $id)
    {
        // Validasi tipe yang diizinkan
        $allowedTypes = ['cryptography', 'web-exploitation'];
        if (!in_array($type, $allowedTypes)) {
            abort(404);
        }
    
        // Cari berdasarkan flag_id jika memang itu yang dikirim di URL
        $question = FlagQuestions::where('flag_id', $id)->first();
        if (!$question) {
            // Coba cari berdasarkan id biasa jika tidak ditemukan
            $question = FlagQuestions::find($id);
            if (!$question) {
                abort(404);
            }
        }
    
        return view("challenge.$type.detail", compact('question', 'type'));
    }
    
    public function submitFlag(Request $request, $type, $id)
    {
        $request->validate([
            'flag' => 'required|string',
        ]);
    
        $username = Auth::user()->username;
        
        // Use the $id from the route as the flag_id
        $flagId = $id;
        
        // Find the flag
        $correctFlag = TheFlag::where('flag_id', $flagId)->first();
        
        if (!$correctFlag) {
            return redirect()->back()->with('error', 'Invalid flag ID');
        }
        
        // Find the question to get points
        $question = FlagQuestions::where('flag_id', $flagId)->first();
        
        // Check if flag is correct
        $isCorrect = $correctFlag && $request->flag === $correctFlag->the_flag;
        
        // Set points to 100 if flag is correct, otherwise 0
        $points = $isCorrect ? 100 : 0;
    
        try {
            UserAnswers::create([
                'username' => $username,
                'flag_id' => $flagId,
                'flag' => $request->flag,
                'status' => $isCorrect ? 1 : 0,
                'points' => $points, // Points set to 100 if correct, 0 if incorrect
            ]);
    
            return redirect()->back()->with(
                $isCorrect ? 'success' : 'error', 
                $isCorrect ? 'Selamat! Flag benar.' : 'Flag salah. Coba lagi!'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan jawaban: ' . $e->getMessage());
        }
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