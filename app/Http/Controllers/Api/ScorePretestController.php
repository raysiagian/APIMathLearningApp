<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScorePretest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScorePretestController extends Controller
{
    public function updateFinalScorePretest(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'score' => 'required|integer',
            ]);

            // Mendapatkan id_user berdasarkan pengguna yang sedang login
            $id_user = Auth::id();

            // Memastikan id_user, id_unit, dan id_pretest ada di dalam request
            $request->validate([
                'id_unit' => 'required|integer',
                'id_pretest' => 'required|integer',
            ]);

            // Membuat instance ScorePretest
            $scorePretest = new ScorePretest();
            $scorePretest->id_unit = $request->id_unit;
            $scorePretest->id_user = $id_user;
            $scorePretest->score = $request->score;
            $scorePretest->id_pretest = $request->id_pretest;
            
            // Menyimpan data ScorePretest
            $scorePretest->save();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $scorePretest]);
        } catch (\Exception $e) {
            // Menangkap dan menampilkan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
