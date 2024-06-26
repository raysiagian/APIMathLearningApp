<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ScorePosttest;
use App\Models\LencanaUser; 

class LeaderboardController extends Controller
{
    public function dataLeaderboard()
    {
        // Subquery untuk mendapatkan id_ScorePosttest terkecil
        $subquery = ScorePosttest::selectRaw('MIN(id_ScorePosttest) as min_id, id_user, id_posttest, id_unit')
            ->groupBy('id_user', 'id_posttest', 'id_unit');
        
        // Ambil nilai Score_Posttest dengan id_ScorePosttest terkecil
        $scorePosttestQuery = ScorePosttest::joinSub($subquery, 'min_scores', function ($join) {
                $join->on('score_posttest.id_ScorePosttest', '=', 'min_scores.min_id');
            })
            ->select('min_scores.id_user', DB::raw('COALESCE(SUM(score_posttest.score), 0) as total_score_posttest'))
            ->groupBy('min_scores.id_user');

        // Subquery untuk mendapatkan ID lencana pengguna terkecil dan total lencana unik untuk setiap pengguna
        $badgeSubquery = LencanaUser::select('id_user', DB::raw('COALESCE(MIN(id_lencanaPengguna), 0) as min_lencana, COALESCE(COUNT(DISTINCT id_bagde), 0) as total_badges'))
            ->groupBy('id_user');

        // Gabungkan dengan query utama untuk mendapatkan data lengkap leaderboard
        $leaderboardData = DB::table(DB::raw("({$scorePosttestQuery->toSql()}) as score_posttests"))
            ->mergeBindings($scorePosttestQuery->getQuery()) // Gunakan getQuery() untuk mendapatkan query builder
            ->leftJoinSub($badgeSubquery, 'badge_counts', 'score_posttests.id_user', '=', 'badge_counts.id_user')
            ->join('user', 'score_posttests.id_user', '=', 'user.id_user') // Join dengan tabel user
            ->select('user.name', DB::raw('COALESCE(score_posttests.total_score_posttest, 0) as total_score_posttest'), DB::raw('COALESCE(badge_counts.total_badges, 0) as total_badges')) // Pilih kolom nama dari tabel user
            ->orderBy('total_score_posttest', 'desc') // Urutkan berdasarkan total_score_posttest dari yang terbesar ke yang terkecil
            ->limit(10) // Ambil hanya 10 data teratas
            ->get();

        return response()->json(['data' => $leaderboardData]);
    }
}
