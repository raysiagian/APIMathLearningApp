<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ScoreUser;
use App\Models\ScorePretest; 

class ScoreController extends Controller
{
    public function index()
    {
        $scores = DB::table('score_pretest')
            ->join('score_posttest', function ($join) {
                $join->on('score_pretest.id_user', '=', 'score_posttest.id_user')
                    ->on('score_pretest.id_unit', '=', 'score_posttest.id_unit');
            })
            ->select('score_pretest.id_user', 'score_pretest.id_unit', 'score_pretest.score AS score_pretest', 'score_posttest.score AS score_posttest')
            ->get();

        return response()->json($scores);
    }

    public function show($id)
    {
        $scores = DB::table('score_pretest')
            ->join('score_posttest', function ($join) {
                $join->on('score_pretest.id_user', '=', 'score_posttest.id_user')
                    ->on('score_pretest.id_unit', '=', 'score_posttest.id_unit');
            })
            ->select('score_pretest.id_user', 'score_pretest.id_unit', 'score_pretest.score AS score_pretest', 'score_posttest.score AS score_posttest')
            ->where('score_pretest.id_user', $id)
            ->get();

        if ($scores->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json(['data' => $scores], 201);
    }

    public function updateFinalScorePretest(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'score_pretest' => 'required|integer',
            ]);
    
            // Mencari atau membuat data skor berdasarkan ID
            $scorePretest = ScorePretest::firstOrNew(['id_pretest' => $id]);
    
            // Mengisi atau memperbarui skor
            $scorePretest->id_pretest = $id;
            $scorePretest->id_unit = $request->input('id_unit'); // Sesuaikan dengan input yang diterima
            $scorePretest->id_user = $request->input('id_user'); // Sesuaikan dengan input yang diterima
            $scorePretest->score = $request->input('score_pretest');
            $scorePretest->save(); // Simpan perubahan ke database
    
            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $scorePretest]);
        } catch (\Exception $e) {
            // Menangkap dan menampilkan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}