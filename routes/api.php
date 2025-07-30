<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EvaluationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('evaluations', EvaluationController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('logs', LogController::class);
    Route::apiResource('segments', SegmentController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
