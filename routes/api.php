<?php

use App\Http\Controllers\Api\FlightDataController;
use App\Http\Controllers\Api\FlightDetailController;
use App\Http\Controllers\Api\FlightListController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix' => 'list'], function () {
        Route::apiResource('flights', FlightListController::class, ['only' => ['index', 'show']]);
    });

    Route::group(['prefix' => 'detail'], function () {
        Route::apiResource('flights', FlightDetailController::class, ['only' => ['index', 'show']]);
    });

    Route::apiResource('flightdata', FlightDataController::class, ['only' => ['store']]);
});
