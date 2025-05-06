<?php

use App\Http\Controllers\SongsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/songs/search', [SongsController::class, 'search']);
Route::apiResource('/songs',SongsController::class);
Route::apiResource('/genres',GenreController::class);
Route::apiResource('/albums',AlbumController::class);
Route::post('/albums/{album}/reviews', [AlbumReviewController::class, 'storeForAlbum']); // IMPORTANT: Protect this route
Route::get('/albums/{album}/reviews', [AlbumReviewController::class, 'indexForAlbum']); // <-- ADD THIS