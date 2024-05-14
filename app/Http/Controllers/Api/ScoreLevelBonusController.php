<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScorelLevelBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreLevelBonusController extends Controller
{
    public function updateFinalScoreLevelBonus(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'score' => 'required|integer',
            ]);

            // Mendapatkan id_user berdasarkan pengguna yang sedang login
            $id_user = Auth::id();

            // Memastikan id_user, id_unit_Bonus, dan id_pretest ada di dalam request
            $request->validate([
                'id_unit_Bonus' => 'required|integer',
                'id_level_bonus' => 'required|integer',
            ]);

            // Membuat instance ScorePretest
            $scoreLevelBonus = new ScorelLevelBonus();
            $scoreLevelBonus->id_unit_Bonus = $request->id_unit_Bonus;
            $scoreLevelBonus->id_user = $id_user;
            $scoreLevelBonus->score = $request->score;
            $scoreLevelBonus->id_level_bonus = $request->id_level_bonus;
            
            // Menyimpan data ScorePretest
            $scoreLevelBonus->save();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $scoreLevelBonus]);
        } catch (\Exception $e) {
            // Menangkap dan menampilkan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}