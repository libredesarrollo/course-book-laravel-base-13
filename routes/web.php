<?php

use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CategoryController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome',['name' => 'John ']);
});
http://larafirststep.test/dashboard/post/post/create
Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('post',PostController::class);
    Route::resource('category',CategoryController::class);
});