<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Version 1.0 routes
 */
Route::prefix('v1.0')->group(function () {
    require_once __DIR__ . '/v1.0/authRoutes.php';
    require_once __DIR__ . '/v1.0/productsRoutes.php';
});