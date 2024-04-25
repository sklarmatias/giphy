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

Route::prefix('/user')->group(function(){
    Route::post('/create', 'App\Http\Controllers\LoginController@create')->middleware('log.route');;
    Route::post('/login', 'App\Http\Controllers\LoginController@login')->middleware('log.route');;
    //Esta ruta está protegida por el oauth
    Route::middleware('auth:api')->get('/gif/query','App\Http\Controllers\UserController@query')->middleware('log.route');;
    Route::middleware('auth:api')->get('/gif/get','App\Http\Controllers\UserController@getGifById')->middleware('log.route');;
    Route::middleware('auth:api')->post('/gif/favorite','App\Http\Controllers\UserController@saveAsFavorite')->middleware('log.route');;
});
