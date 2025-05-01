<?php

namespace App\Http\Controllers;
use App\Models\FlagQuestions;

class HomepageController extends Controller
{
    public function index()
    {
        // Ambil total tantangan untuk dua jenis kategori
        $total_web_exploitation = FlagQuestions::where('type', 'web-exploitation')->count();
        $total_cryptography = FlagQuestions::where('type', 'cryptography')->count();

        $types = FlagQuestions::select('type')->distinct()->pluck('type');

        $challenge_counts = [];
        foreach ($types as $type) {
            $challenge_counts[$type] = FlagQuestions::where('type', $type)->count();
        }
    
        return view('homepage', [
            'types' => $types,
            'challenge_counts' => $challenge_counts
        ]);
    }
}
