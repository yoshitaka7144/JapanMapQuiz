<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TimeLimitValueController;
use App\Http\Controllers\QuizCountValueController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// 地図マスタデータ取得
Route::get("/maps", [MapController::class, "index"]);

// 地図名一覧のみ取得
Route::get("/maps/names", [MapController::class, "allNames"]);

// 地方区分マスタデータ取得
Route::get("/classifications", [ClassificationController::class, "index"]);

// 制限時間マスタデータ取得
Route::get("/time_limit_values", [TimeLimitValueController::class, "index"]);

// 問題数マスタデータ取得
Route::get("/quiz_count_values", [QuizCountValueController::class, "index"]);
