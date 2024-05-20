<?php

// app/Http/Controllers/Api/StatisticController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScorePretest;
use App\Models\ScorePosttest;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function updateStatistics()
    {
        $userId = Auth::id();

        // Ambil skor pretest dan posttest terkecil per unit untuk user yang login
        $pretestScores = ScorePretest::where('id_user', $userId)
            ->select('id_unit', DB::raw('MIN(id_ScorePretest) as id_ScorePretest'))
            ->groupBy('id_unit')
            ->get();

        $posttestScores = ScorePosttest::where('id_user', $userId)
            ->select('id_unit', DB::raw('MIN(id_ScorePosttest) as id_ScorePosttest'))
            ->groupBy('id_unit')
            ->get();

        foreach ($pretestScores as $pretestScore) {
            $scorePretest = ScorePretest::find($pretestScore->id_ScorePretest);
            Statistic::updateOrCreate(
                [
                    'id_user' => $userId,
                    'id_unit' => $scorePretest->id_unit,
                ],
                [
                    'score_pretest' => $scorePretest->score,
                ]
            );
        }

        foreach ($posttestScores as $posttestScore) {
            $scorePosttest = ScorePosttest::find($posttestScore->id_ScorePosttest);
            Statistic::updateOrCreate(
                [
                    'id_user' => $userId,
                    'id_unit' => $scorePosttest->id_unit,
                ],
                [
                    'score_posttest' => $scorePosttest->score,
                ]
            );
        }

        return response()->json(['message' => 'Statistics updated successfully']);
    }

    public function getStatistics()
    {
        $userId = Auth::id();
        $statistics = Statistic::where('id_user', $userId)->get();
        return response()->json($statistics);
    }
}
