<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\HomeController;
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

Route::controller(HomeController::class)
    ->group(function () {
    Route::get('', 'index')->name('home');
});

// Route::controller(PostController::class)
//     ->name('post.')
//     ->prefix('{post_type}')
//     ->group(function() {
//     Route::get('', 'index')->name('index')->whereIn('post_type', ['blog', 'project']);
//     Route::prefix('{parent}/{slug}')
//         ->group(function () {
//         Route::get('', 'show')->name('show')->whereIn('post_type', ['blog', 'project']);
//         Route::controller(PostCommentController::class)
//             ->name('comments.')
//             ->prefix('comments')
//             ->group(function () {
//             Route::get('{comment_id}', 'index')->name('replies')->whereIn('post_type', ['blog', 'project']);
//         });
//     });
// });

Route::group([
    'prefix' => '{post_type}',
    'where' => [
        'post_type' => 'blog|project(s)?',
    ],
], function() {
    Route::name('post.')->group(function () {
        Route::controller(PostController::class)->group(function() {
            Route::get('', 'index')->name('index');
            Route::prefix('{parent}/{slug}')->group(function () {
                Route::get('', 'show')->name('show');
                Route::controller(PostCommentController::class)
                    ->name('comments.')
                    ->prefix('comments')
                    ->group(function () {
                    Route::get('{comment_id?}', 'index')->name('replies')->whereNumber('comment_id');
                    Route::post('create', 'create')->name('create');
                });
            });
        });
    });
});

//Installation routes
require_once __DIR__ . '/v1.0/installRoutes.php';
