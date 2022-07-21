<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallationController;

/**
 * Here's where all routes relating to products
 */

Route::controller(InstallationController::class)->group(function() {
    Route::name('setup.')->group(function () {
        Route::prefix('setup')->group(function () {
            //Configuration
            Route::name('configure.')->prefix('configure')->group(function () {
                Route::match(['get'], '', 'configure')->name('show');
                Route::match(['post'], 'save', 'saveConfiguration')->name('save');
            });
            
            //Installation
            Route::name('install.')->prefix('install')->group(function () {
                Route::match(['get'], '/', 'install')->name('show');
                Route::match(['post'], 'save', 'saveInstallation')->name('save');
            });

            //Admin registration
        });
    });
});