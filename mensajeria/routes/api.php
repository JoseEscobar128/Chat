<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
Route::post('/registro', [RegistroController::class, 'registro']);
Route::post('/login', [LoginController::class, 'login']);


Route::get('/hola', function () {
    return response()->json(['message' => 'Hola']);
});