<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GifController;

// 1. Rutas públicas de usuarios
Route::prefix('/users')->group(function() {
    Route::post('/', [LoginController::class, 'create'])->middleware('log.route');
    Route::post('/login', [LoginController::class, 'login'])->middleware('log.route');
});

// 2. Rutas protegidas de GIFs
Route::middleware(['auth:api', 'log.route'])->group(function() {
    
    // Mapeo directo al nuevo GifController
    Route::get('/gifs', [GifController::class, 'query']);
    Route::get('/gifs/{id}', [GifController::class, 'getGifById']);
    
    // Mapeo de relación al UserController
    Route::post('/gifs/favorites', [UserController::class, 'saveAsFavorite']);
});
