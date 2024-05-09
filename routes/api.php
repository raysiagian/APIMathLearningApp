<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\Api\SuperAdminAuthController;
use App\Http\Middleware\RoleCheckMiddleware;
use App\Http\Controllers\Api\ScoreUserController;


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

    // Score
    Route::get('/user/scores', [ScoreUserController::class, 'index']);
});



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
Route::put('/pretest/{id}/update-final-score', [PretestController::class, 'updateFinalScore']);

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


// API QuestionPretest
Route::post("addQuestionPosttest",[QuestionPosttestController::class, "store"]);
Route::get("getQuestionPosttest",[QuestionPosttestController::class, "index"]);

Route::post("addQuestionLevelBonus",[QuestionLevelBonusController::class, "store"]);
Route::get("getQuestionLevelBonus",[QuestionLevelBonusController::class, "index"]);


// API Material Video
Route::post("addMaterialVideo",[MaterialVideoController::class, "store"]);
Route::get("getMaterialVideo",[MaterialVideoController::class, "index"]);

