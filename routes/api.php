<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\MapController;

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

// 地図データ一覧取得
Route::get("/maps", [MapController::class, "index"]);

// 地図名一覧のみ取得
Route::get("/maps/names", [MapController::class, "allNames"]);

// 地方区分データ一覧取得
Route::get("/classifications", [ClassificationController::class, "index"]);
