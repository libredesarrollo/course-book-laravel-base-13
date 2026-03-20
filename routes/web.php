<?php

use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CategoryController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome',['name' => 'John ']);
});

// Route::get('/post', [PostController::class, 'index']);
// Route::get('/post/create', [PostController::class, 'create']);
// // Route::get('/post/{post}', [PostController::class, 'edit']);
// // Route::get('/post/{post:int}', [PostController::class, 'edit']);
// Route::get('/post/{post}', [PostController::class, 'edit']);
// Route::get('/post/delete/{category}', [PostController::class, 'destroy']);

Route::resource('post',PostController::class);
Route::resource('category',CategoryController::class);