<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/**
 * Here's where all routes relating to user authenticated are registered.
 */

Route::controller(AuthController::class)->group(function() {
    Route::name('auth.')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', 'login')->name('login');
            Route::post('register', 'register')->name('register');
            Route::post('logout', 'logout')->name('logout');
            Route::post('refresh-token', 'refresh')->name('refreshToken');
            Route::name('create.')->prefix('new')->group(function() {
                Route::get('/', 'create')->name('new');
                Route::post('/save', 'store')->name('submit');
            });
        });
    });
});