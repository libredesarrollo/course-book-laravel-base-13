<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('post/all', [App\Http\Controllers\Api\PostController::class, 'all']);
Route::get('post/{post}', [App\Http\Controllers\Api\PostController::class, 'show']);
Route::get('post/slug/{post:slug}', [App\Http\Controllers\Api\PostController::class, 'show']);

Route::get('category/all', [App\Http\Controllers\Api\CategoryController::class, 'all']);
Route::get('category/{category}', [App\Http\Controllers\Api\CategoryController::class, 'show']);
Route::get('category/slug/{category:slug}', [App\Http\Controllers\Api\CategoryController::class, 'show']);



// Route::resource('category', App\Http\Controllers\Api\CategoryController::class)->except(["create", "edit"])->middleware('auth:sanctum');;
// Route::resource('post', App\Http\Controllers\Api\PostController::class)->except(["create", "edit"]);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('category', App\Http\Controllers\Api\CategoryController::class)->except(["create", "edit"]);
    Route::resource('post', App\Http\Controllers\Api\PostController::class)->except(["create", "edit"]);
});



Route::post('user/login',[App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('user/logout/{tokenId}',[App\Http\Controllers\Api\UserController::class, 'logout']);