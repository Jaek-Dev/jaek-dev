<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::controller(PostController::class)
    ->name('blog.')
    ->prefix('blog')
    ->group(function() {
    Route::get('', 'index')->name('index');
    Route::get('/{parent}/{slug}.aspx', 'show')->name('show');
});

//Installation routes
require_once __DIR__ . '/v1.0/installRoutes.php';
