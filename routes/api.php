<?php

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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::get('/books', [\App\Http\Controllers\Api\BookController::class, 'index']);
    Route::post('/books', [\App\Http\Controllers\Api\BookController::class, 'store']);
    Route::get('/books/{id}', [\App\Http\Controllers\Api\BookController::class, 'show']);
    Route::put('/books/{id}', [\App\Http\Controllers\Api\BookController::class, 'update']);
    Route::delete('/books/{id}', [\App\Http\Controllers\Api\BookController::class, 'destroy']);
});
