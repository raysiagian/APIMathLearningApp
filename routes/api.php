<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\UnitController;

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
Route::post("login", [ApiController::class,"login"]);

Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class,"logout"]);
});

// API Materi 
Route::post("addMateri",[MateriController::class, "store"]);
Route::get('getMateri', [MateriController::class, 'index']);

// API Unit
Route::post("addUnit",[UnitController::class, "store"]);
Route::get("getUnit",[UnitController::class, "index"]);