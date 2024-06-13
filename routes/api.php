<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\MaterialVideoController;
use App\Http\Controllers\Api\PretestController;
use App\Http\Controllers\Api\PosttestController;
use App\Http\Controllers\Api\QuestionPretestController;
use App\Http\Controllers\Api\QuestionPosttestController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\LevelBonusController;
use App\Http\Controllers\Api\UnitBonusController;
use App\Http\Controllers\Api\QuestionLevelBonusController;
use App\Http\Controllers\Api\ScorePretestController;
use App\Http\Controllers\Api\ScorePosttestController;
use App\Http\Controllers\Api\ScoreLevelBonusController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\WatchMaterialVideoController;
use App\Http\Controllers\Api\LencanaPenggunaController;
use App\Http\Controllers\Api\BadgeController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\SuperAdminAuthController;
use App\Http\Middleware\RoleCheckMiddleware;
use App\Http\Controllers\Api\ScoreController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route untuk admin
Route::post('admin/register', [AdminAuthController::class, 'register']);
Route::post('admin/login', [AdminAuthController::class, 'login']);

// Rute yang hanya dapat diakses oleh admin
Route::middleware(['auth:sanctum', RoleCheckMiddleware::class])->group(function () {
    // Contoh rute yang hanya dapat diakses oleh admin
    Route::get('admin/dashboard', function () {
        return response()->json(['message' => 'Admin dashboard']);
    });
    
});

// Api User

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('check-email-availability', [AuthController::class, 'checkEmailAvailability']);
Route::get('getUser', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/username', [AuthController::class, 'getUsername']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/edit-username', [AuthController::class, 'editUsername']);

    Route::get('/user/pretest-status', [PretestController::class, 'checkUserPretestStatus']);
    Route::get('/user/posttest-status', [PosttestController::class, 'checkUserPosttestStatus']);
    Route::get('/user/material-video-status', [MaterialVideoController::class, 'checkUserMaterialVideoStatus']);
    Route::put('/pretest/{id}/update-final-score-pretest', [ScorePretestController::class, 'updateFinalScorePretest']);
    Route::put('/posttest/{id}/update-final-score-posttest', [ScorePosttestController::class, 'updateFinalScorePosttest']);

    Route::put('/levelbonus/{id}/update-final-score-level-bonus', [ScoreLevelBonusController::class, 'updateFinalScoreLevelBonus']);


    Route::get('/watch-material-video/status', [WatchMaterialVideoController::class, 'checkUserVideoStatus']);
    Route::put('/watch-material-video/{id}/mark-completed', [WatchMaterialVideoController::class, 'markVideoCompleted']);
    

    Route::get('/user/score-pretest-by-idunit/{id_unit}', [ScorePretestController::class, 'getPretestByUnit']);
    Route::get('/user/score-pretest-by-idunit-smallid/{id_unit}', [ScorePretestController::class, 'getPretestByUnitSmallIdScore']);
    Route::get('/user/smallest-score-pretest-by-unit', [ScorePretestController::class, 'getSmallestScorePretestByUnit']);

    Route::get('/user/get-scores-pretest', [ScorePretestController::class, 'getScoresPretest']);
    Route::get('/user/get-scores-pretest-idmateri/{materiId}', [ScorePretestController::class, 'getScoresPretestByMateri']);






    Route::get('/user/score-posttest-by-idunit/{id_unit}', [ScorePosttestController::class, 'getPosttestByUnit']);
    Route::get('/user/score-posttest-by-idunit-smallid/{id_unit}', [ScorePosttestController::class, 'getPosttestByUnitSmallIdScore']);
    Route::get('user/smallest-score-posttest-by-unit', [ScorePosttestController::class, 'getSmallestScorePosttestByUnit']);
    Route::get('user/get-scores-posttest', [ScorePosttestController::class, 'getScoresPosttest']);
    Route::get('/user/get-scores-posttest-idmateri/{materiId}', [ScorePosttestController::class, 'getScoresPosttestByMateri']);

    Route::get('/user/watch-video-by-idunit/{id_unit}', [WatchMaterialVideoController::class, 'getWatchVideoByUnit']);
    Route::get('/user/watch-video-by-idunit-smallid/{id_unit}', [WatchMaterialVideoController::class, 'getWatchVideoByUnitSmallIdVideo']);

    Route::post('update-statistics', [StatisticController::class, 'updateStatistics']);
    Route::get('statistics', [StatisticController::class, 'getStatistics']);




});

Route::get('/user/{id}/lives', [AuthController::class, 'getLivesByUserId']);
Route::put('/users/{id}/update-lives',  [AuthController::class, 'updateLivesByUserId']);

Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);



// API Role
Route::post("addRole",[MateriController::class, "store"]);
Route::get('getRole', [MateriController::class, 'index']);

// API Materi 
Route::post("addMateri",[MateriController::class, "store"]);
Route::get('getMateri', [MateriController::class, 'index']);
Route::get('/materi/{id}', [MateriController::class, 'show']);

// API Unit
Route::post("addUnit",[UnitController::class, "store"]);
Route::get("getUnit",[UnitController::class, "index"]);

Route::post("addUnitBonus",[UnitBonusController::class, "store"]);
Route::get("getUnitBonus",[UnitBonusController::class, "index"]);

// API Level
Route::post("addLevel",[LevelController::class, "store"]);
Route::get("getLevel",[LevelController::class, "index"]);

// API Pretest
Route::post("addPretest",[PretestController::class, "store"]);
Route::get("getPretest",[PretestController::class, "index"]);
// Route::put('/pretest/{id}/update-final-score', [PretestController::class, 'updateFinalScorePretest']);
Route::put('/pretest/{id}/update-final-score', [PretestController::class, 'updateFinalScore']);

Route::get('/total-score-pretest-all-user', [ScorePretestController::class, 'getTotalPretestScoreForAllUsers']);

Route::post("addLevelBonus",[LevelBonusController::class, "store"]);
Route::get("getLevelBonus",[LevelBonusController::class, "index"]);
Route::put('/levelbonus/{id}/update-final-score', [LevelBonusController::class, 'updateFinalScore']);


// API QuestionPretest
Route::post("addQuestionPretest",[QuestionPretestController::class, "store"]);
Route::get("getQuestionPretest",[QuestionPretestController::class, "index"]);

// API Pretest
Route::post("addPosttest",[PosttestController::class, "store"]);
Route::get("getPosttest",[PosttestController::class, "index"]);
Route::put('/posttest/{id}/update-final-score', [PosttestController::class, 'updateFinalScore']);

Route::get('/total-score-posttest-all-user', [ScorePosttestController::class, 'getTotalPosttestScoreForAllUsers']);
Route::get('/leaderboard-posttest-all-user', [ScorePosttestController::class, 'getLeaderboardScorePosttest']);



// API QuestionPretest
Route::post("addQuestionPosttest",[QuestionPosttestController::class, "store"]);
Route::get("getQuestionPosttest",[QuestionPosttestController::class, "index"]);

Route::post("addQuestionLevelBonus",[QuestionLevelBonusController::class, "store"]);
Route::get("getQuestionLevelBonus",[QuestionLevelBonusController::class, "index"]);


// API Material Video
Route::post("addMaterialVideo",[MaterialVideoController::class, "store"]);
Route::get("getMaterialVideo",[MaterialVideoController::class, "index"]);

//ScorePretest||Posttest
Route::get('/scores', [ScoreController::class, 'index']);
Route::get('/scores/{id}', [ScoreController::class, 'show']);


// API untuk lencana
Route::get('/badges', [BadgeController::class, 'index']);
Route::get('/badges/{id}', [BadgeController::class, 'show']);
Route::post('/addBadges', [BadgeController::class, 'store']);
Route::post('/badges/{id}', [BadgeController::class, 'update']);
Route::delete('/badges/{id}', [BadgeController::class, 'destroy']);
Route::get('/badges/by-posttest/{id_posttest}', [BadgeController::class, 'getByPosttestId']);
Route::get('/images/{filename}', function ($filename) {
    $path = storage_path('images/' . $filename); 
    if (!file_exists($path)) {
        return Response::json(['error' => 'File not found'], 404); 
    }

    // Jika file gambar ada, kembalikan respons dengan file gambar
    return response()->file($path);
})->name('image');

//lencanaPengguna
Route::get('/lencanaPengguna', [LencanaPenggunaController::class, 'index']);
Route::get('/lencana-pengguna/{id_user}', [LencanaPenggunaController::class, 'index']);
Route::post('/addLencanaPengguna', [LencanaPenggunaController::class, 'store']);
Route::get('/total-badge-user', [LencanaPenggunaController::class, 'getTotalBadgesUser']);

Route::get('/leaderboard', [LeaderboardController::class, 'dataLeaderboard']);