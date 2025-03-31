<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumVoteController;
use App\Http\Middleware\AdminMiddleware;

Route::middleware('auth:sanctum')
    ->group(function (){

        // Album
        Route::get('/getSaved', [AlbumController::class, 'index']);
        Route::post('/album', [AlbumController::class, 'store']);
        Route::get('/album/list', [AlbumController::class, 'index']);
        Route::post('/vote', [AlbumVoteController::class, 'store']);
        Route::get('/album/song/{id}', [AlbumController::class, 'show']);
        Route::delete('/vote/destroy/{id}', [AlbumVoteController::class, 'destroy']);
        Route::get('/vote/list', [AlbumVoteController::class, 'index']);
        Route::get('/search/album', [AlbumController::class ,'search']);
        Route::delete('/album/destroy/{id}', [AlbumController::class, 'destroy']);

        //Song
        Route::post('/create/song', [SongController::class, 'store']);

        // Authentication
        Route::post('/logout', [AuthController::class, 'logout']);
    });


// Route::get('/getSaved', [AlbumController::class, 'index'])->middleware('auth:sanctum');

Route::post('/saveData', [UserController::class, 'store']);
// Route::post('/album', [AlbumController::class, 'store']);
Route::put('/updateData/{id}', [UserController::class, 'update']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('/album/list', [AlbumController::class, 'index']);
// Route::post('/create/song', [SongController::class, 'store']);
// Route::post('/vote', [AlbumVoteController::class, 'store']);
// Route::get('/album/song/{id}', [AlbumController::class, 'show']);

// Route::delete('/vote/destroy/{id}', [AlbumVoteController::class, 'destroy']);

// Route::get('/vote/list', [AlbumVoteController::class, 'index']);

// Route::get('/search/album', [AlbumController::class ,'search']);

// Route::delete('/album/destroy/{id}', [AlbumController::class, 'destroy']);