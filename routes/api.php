<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContragentController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [UserController::class, 'me']);

    Route::prefix('contragents')->group(function () {
        Route::get('/', [ContragentController::class, 'index']);
        Route::post('/', [ContragentController::class, 'store']);
    });
});
