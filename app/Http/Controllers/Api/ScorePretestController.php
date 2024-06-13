<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScorePretest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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


    public function showScorePretestStatus(Request $request)
    {   
        // Mendapatkan user yang sedang login
        {
            $id_user = Auth::id();
            $score = ScorePretest::where('id_user', $id_user)->get();
            return response()->json($score);
        }
    }

    public function getPretestByUnit($unitId)
    {
        $userId = Auth::id();
        $scores = ScorePretest::where('id_user', $userId)
                              ->where('id_unit', $unitId)
                              ->get();
        if ($scores->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json($scores);
    }

    public function getPretestByUnitSmallIdScore($unitId)
    {
        $userId = Auth::id();
        
        // Query untuk mengambil data dengan id_unit tertentu yang dimiliki oleh user yang login,
        // diurutkan berdasarkan id_ScorePreTest, dan hanya mengambil baris pertama.
        $score = ScorePretest::where('id_user', $userId)
                             ->where('id_unit', $unitId)
                             ->orderBy('id_ScorePreTest', 'asc')
                             ->first();

        if ($score) {
            return response()->json($score);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function getTotalPretestScoreForAllUsers()
    {
        try {
            // Subquery untuk mendapatkan id_ScorePreTest terkecil untuk setiap kombinasi id_user dan id_unit
            $subquery = ScorePretest::selectRaw('MIN(id_ScorePreTest) as min_id')
                                    ->groupBy('id_user', 'id_unit')
                                    ->pluck('min_id');

            // Ambil detail ScorePretest berdasarkan hasil subquery
            $scores = ScorePretest::whereIn('id_ScorePreTest', $subquery)
                                ->get();

            // Kelompokkan hasil berdasarkan id_user dan hitung total skor untuk setiap user
            $totalScores = $scores->groupBy('id_user')->map(function ($userScores) {
                return $userScores->sum('score'); // Asumsi kolom skor bernama 'score'
            });

            return response()->json(['total_scores' => $totalScores]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    




    public function getSmallestScorePretestByUnit()
    {
        $userId = Auth::id();
    
        // Subquery untuk mendapatkan id_ScorePreTest terkecil di setiap unit
        $subquery = ScorePretest::selectRaw('MIN(id_ScorePreTest) as min_id, id_unit')
            ->where('id_user', $userId)
            ->groupBy('id_unit')
            ->pluck('min_id');
    
        // Ambil detail ScorePretest berdasarkan hasil subquery dan urutkan berdasarkan id_unit
        $scores = ScorePretest::whereIn('id_ScorePreTest', $subquery)
            ->orderBy('id_unit')
            ->get();
    
        return response()->json($scores);
    }

    public function getScoresPretest()
    {
        try {
            $id_user = Auth::id();

            $scores = ScorePretest::where('id_user', $id_user)->get();

            return response()->json(['data' => $scores]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getScoresPretestByMateri($materiId)
    {
        try {
            $id_user = Auth::id();  
            
            // Ambil unit yang berkaitan dengan id_materi yang dipilih
            $units = DB::table('unit')
                        ->where('id_materi', $materiId)
                        ->pluck('id_unit');
    
            // Subquery untuk mendapatkan id_ScorePreTest terkecil di setiap unit yang sesuai dengan id_user dan id_unit dari materi yang dipilih
            $subquery = ScorePretest::selectRaw('MIN(id_ScorePreTest) as min_id')
                ->where('id_user', $id_user)
                ->whereIn('id_unit', $units)
                ->groupBy('id_unit')
                ->pluck('min_id');
    
            // Ambil detail ScorePretest berdasarkan hasil subquery
            $scores = ScorePretest::whereIn('id_ScorePreTest', $subquery)
                ->get();
    
            return response()->json(['data' => $scores]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    
    
}
