<?php

use App\Http\Controllers\SongsController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/songs/search', [SongsController::class, 'search']);
Route::apiResource('/songs',SongsController::class);
Route::apiResource('/genres',GenreController::class);