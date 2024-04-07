<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PretestController;
use App\Http\Controllers\Api\QuestionPretestController;
use App\Http\Controllers\Api\QuestionPosttestController;
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
Route::post("register", [ApiController::class,"register"]);
Route::post('check-email-availability', [ApiController::class, 'checkEmailAvailability']);
Route::post("login", [ApiController::class,"login"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);
});

Route::get('getUser', [ApiController::class, 'index']);

// API Materi 
Route::post("addMateri",[MateriController::class, "store"]);
Route::get('getMateri', [MateriController::class, 'index']);

// API Unit
Route::post("addUnit",[UnitController::class, "store"]);
Route::get("getUnit",[UnitController::class, "index"]);


// API Level
Route::post("addLevel",[LevelController::class, "store"]);
Route::get("getLevel",[LevelController::class, "index"]);

// API Pretest
Route::post("addPretest",[PretestController::class, "store"]);
Route::get("getPretest",[PretestController::class, "index"]);


// API QuestionPretest
Route::post("addQuestionPretest",[QuestionPretestController::class, "store"]);
Route::get("getQuestionPretest",[QuestionPretestController::class, "index"]);

// API Pretest
Route::post("addPosttest",[PretestController::class, "store"]);
Route::get("getPosttest",[PretestController::class, "index"]);


// API QuestionPretest
Route::post("addQuestionPosttest",[QuestionPosttestController::class, "store"]);
Route::get("getQuestionPosttest",[QuestionPosttestController::class, "index"]);


