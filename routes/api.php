<?php

use App\Http\Controllers\API\Auth\LoginUserController;
use App\Http\Controllers\API\Auth\RegisterUserController;
use App\Http\Controllers\API\Seat\BookSeatController;
use App\Http\Controllers\API\Seat\ListAvailableSeatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], static function () {
    Route::controller(LoginUserController::class)->group(function () {
        Route::post('login', 'login');
        Route::delete('logout', 'logout')->middleware('auth:sanctum');
    });
    Route::post('register', RegisterUserController::class);
});

Route::get('seats', ListAvailableSeatsController::class);
Route::post('seats/{seat}', BookSeatController::class)->middleware('auth:sanctum');
