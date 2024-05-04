<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PretestController;
use App\Http\Controllers\Api\PosttestController;
use App\Http\Controllers\Api\QuestionPretestController;
use App\Http\Controllers\Api\QuestionPosttestController;
use App\Http\Controllers\Api\MaterialvideoController;
use App\Http\Controllers\Api\QuestionLevelBonusController;
use App\Http\Controllers\Api\UnitBonusController;
use App\Http\Controllers\Api\LevelBonusController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Api Routes

// API Autentikasi 
Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('check-email-availability', [AuthController::class, 'checkEmailAvailability']);
Route::get('getUser', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/getUsername', [AuthController::class, 'getUsername']);

// API Materi 
Route::post("addMateri",[MateriController::class, "store"]);
Route::get('getMateri', [MateriController::class, 'index']);

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

Route::post("addQuestionLevelBonus",[QuestionLevelBonusController::class, "store"]);
Route::get("getQuestionLevelBonus",[QuestionLevelBonusController::class, "index"]);


// API Posttest
Route::post("addPosttest",[PosttestController::class, "store"]);
Route::get("getPosttest",[PosttestController::class, "index"]);
Route::put('/posttest/{id}/update-final-score', [PosttestController::class, 'updateFinalScore']);


// API QuestionPosttest
Route::post("addQuestionPosttest",[QuestionPosttestController::class, "store"]);
Route::get('getQuestionPosttest', [QuestionPosttestController::class, 'index']);


Route::post("addMaterialVideo",[MaterialVideoController::class, "store"]);
Route::get("getMaterialVideo",[MaterialVideoController::class,"index"]);


