<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;

use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    Route::get('/read-messages/{userId}', [MessageController::class, 'readMessages']);
});
Route::middleware('auth:sanctum')->get('/messages/{userId}', [MessageController::class, 'readMessages']);




Route::post('/registro', [RegistroController::class, 'registro']);
Route::post('/login', [LoginController::class, 'login']);

//Route::post('/send-message', [MessageController::class, 'sendMessage']);
//Route::get('/read-messages/{userId}', [MessageController::class, 'readMessages']);

Route::get('/hola', function () {
    return response()->json(['message' => 'Hola']);
});