<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');

Route::group(['prefix' => 'dashboard', 'middleware'=> ['auth',App\Http\Middleware\UserIsAdminMiddleware::class]], function () {
    Route::resources([
        'post' => PostController::class,
        'category' => CategoryController::class,
    ]);
});

