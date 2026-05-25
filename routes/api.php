<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Public API
    Route::get('/tracks', [\App\Http\Controllers\Api\TrackController::class, 'index']);
    Route::get('/tracks/{track}', [\App\Http\Controllers\Api\TrackController::class, 'show']);
    Route::get('/albums/{album}', [\App\Http\Controllers\Api\AlbumController::class, 'show']);
    Route::get('/artists/{artist}', [\App\Http\Controllers\Api\ArtistController::class, 'show']);
    Route::get('/genres', [\App\Http\Controllers\Api\GenreController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\Api\SearchController::class, 'index']);

    // Auth
    Route::post('/auth/send-code', [\App\Http\Controllers\Api\AuthController::class, 'sendCode']);
    Route::post('/auth/verify', [\App\Http\Controllers\Api\AuthController::class, 'verify']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
        Route::post('/auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

        // Player & Interactions
        Route::post('/stream', [\App\Http\Controllers\Api\StreamController::class, 'store']);
        Route::post('/like', [\App\Http\Controllers\Api\InteractionController::class, 'toggleLike']);
        Route::post('/follow', [\App\Http\Controllers\Api\InteractionController::class, 'toggleFollow']);

        // Library
        Route::get('/library/liked', [\App\Http\Controllers\Api\LibraryController::class, 'liked']);
        Route::get('/library/playlists', [\App\Http\Controllers\Api\LibraryController::class, 'playlists']);
        Route::get('/library/history', [\App\Http\Controllers\Api\LibraryController::class, 'history']);
    });
});
