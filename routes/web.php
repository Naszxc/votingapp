<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('pages/login');
})->name('login');

Route::middleware('auth:sanctum')
    ->group(function (){
        Route::get('/main', function () {
            return view('pages/mainPage');
        });
    });

Route::middleware(['auth:sanctum', AdminMiddleware::class])
    ->group(function () {
        Route::get('/admin', function () {
            return view('pages/adminPage');
        });
    });