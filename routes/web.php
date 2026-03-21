<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Middleware\TestMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');
http:// larafirststep.test/dashboard/post/post/create

// Route::middleware([App\Http\Middleware\TestMiddleware::class])->group(function () {
Route::group(['prefix' => 'dashboard', 'middleware' => [TestMiddleware::class]], function () {
    // Route::resource('post',PostController::class);
    // Route::resource('category',CategoryController::class)
    // ->except('show');
    // ->except(['show'])
    // ->only(['edit']);
    Route::resources([
        'post' => PostController::class,
        'category' => CategoryController::class,
    ]);
});
// ->middleware();
// });
