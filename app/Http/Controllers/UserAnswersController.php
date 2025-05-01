<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubmission;
use App\Models\FlagQuestions;
use App\Models\TheFlag;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends Controller
{
    // Menampilkan semua jawaban yang dikirim pengguna
    public function index()
    {
        $submissions = UserSubmission::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.submissions.index', compact('submissions'));
    }

    // Menampilkan detail jawaban tertentu
    public function show($id)
    {
        $submission = UserSubmission::where('user_id', Auth::id())->findOrFail($id);
        return view('user.submissions.show', compact('submission'));
    }

    // Menyimpan jawaban pengguna
    public function store(Request $request, $questionId)
    {
        $request->validate([
            'flag' => 'required|string',
        ]);

        $question = FlagQuestions::findOrFail($questionId);
        $correctFlag = TheFlag::where('flag_id', $question->flag_id)->first();

        // Cek apakah jawaban benar
        $isCorrect = $correctFlag && $request->flag === $correctFlag->the_flag;

        // Simpan jawaban ke database
        UserSubmission::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'flag_id' => $question->flag_id
            ],
            [
                'is_correct' => $isCorrect,
                'submitted_flag' => $request->flag
            ]
        );

        if ($isCorrect) {
            return redirect()->back()->with('success', 'Selamat! Flag benar.');
        } else {
            return redirect()->back()->with('error', 'Flag salah. Coba lagi!');
        }
    }

    // Menghapus jawaban pengguna
    public function destroy($id)
    {
        $submission = UserSubmission::where('user_id', Auth::id())->findOrFail($id);
        $submission->delete();

        return redirect()->route('user.submissions.index')->with('success', 'Jawaban berhasil dihapus.');
    }
}
