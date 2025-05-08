<?php

use App\Http\Controllers\SongsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumReviewController;
use App\Http\Controllers\ArtistReviewController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/songs/search', [SongsController::class, 'search']);
Route::apiResource('/songs',SongsController::class);
Route::apiResource('/genres',GenreController::class);
Route::apiResource('/albums',AlbumController::class);
Route::apiResource('/artists',ArtistController::class);
Route::post('/albums/{album}/reviews', [AlbumReviewController::class, 'store']); // IMPORTANT: Protect this route
Route::get('/albums/{album}/reviews', [AlbumReviewController::class, 'index']); // <-- ADD THIS
Route::post('/artists/{artist}/reviews', [ArtistReviewController::class, 'store']); // IMPORTANT: Protect this route
Route::get('/artists/{artist}/reviews', [ArtistReviewController::class, 'index']); // <-- ADD THIS

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email'); // name is good practice
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update'); // name is good practice

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});