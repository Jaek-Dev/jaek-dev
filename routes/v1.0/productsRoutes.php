<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

/**
 * Here's where all routes relating to products
 */

Route::controller(ProductsController::class)->group(function() {
    Route::name('products.')->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('/', 'index')->name('all');
            // Route::match(['post'], 'login', 'login')->name('login');
            // Route::match(['post'], 'register', 'register')->name('register');
            // Route::match(['post'], 'logout', 'logout')->name('logout');
            // Route::match(['post'], 'refresh-token', 'refresh')->name('refreshToken');
            // Route::name('create.')->prefix('new')->group(function() {
            //     Route::get('/', 'create')->name('new');
            //     Route::post('/save', 'store')->name('submit');
            // });
        });
    });
});