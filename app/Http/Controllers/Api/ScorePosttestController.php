<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScorePosttest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScorePosttestController extends Controller
{
    public function updateFinalScorePosttest(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'score' => 'required|integer',
            ]);

            // Mendapatkan id_user berdasarkan pengguna yang sedang login
            $id_user = Auth::id();

            // Memastikan id_user, id_unit, dan id_posttest ada di dalam request
            $request->validate([
                'id_unit' => 'required|integer',
                'id_posttest' => 'required|integer',
            ]);

            // Membuat instance ScorePretest
            $scorePosttest = new ScorePosttest();
            $scorePosttest->id_unit = $request->id_unit;
            $scorePosttest->id_user = $id_user;
            $scorePosttest->score = $request->score;
            $scorePosttest->id_posttest = $request->id_posttest;
            
            // Menyimpan data ScorePretest
            $scorePosttest->save();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $scorePosttest]);
        } catch (\Exception $e) {
            // Menangkap dan menampilkan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
