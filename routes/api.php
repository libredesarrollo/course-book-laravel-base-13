<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('post/all', [PostController::class, 'all']);
Route::get('post/{post}', [PostController::class, 'show']);
Route::get('post/slug/{post:slug}', [PostController::class, 'show']);

Route::get('category/all', [CategoryController::class, 'all']);
Route::get('category/{category}', [CategoryController::class, 'show']);
Route::get('category/slug/{category:slug}', [CategoryController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum', 'as' => 'api.'], function () {
    Route::resource('category', CategoryController::class)->except(['create', 'edit', 'index']);
    Route::resource('post', PostController::class)->except(['create', 'edit', 'index']);
});
Route::group(['as' => 'api.'], function () {
    Route::resource('category', CategoryController::class)->only(['index']);
    Route::resource('post', PostController::class)->only(['index']);
});

Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('user/logout/{tokenId}', [UserController::class, 'logout']);
});
    Route::get('stripe/create-session/{priceId}/{successURL?}/{cancelUrl?}', [StripeController::class, 'createSession']);
    Route::get('stripe/get-session/{sessionId}', [StripeController::class, 'checkPayment']);
    Route::get('stripe/get-payment-intent/{paymentIntentId}', [StripeController::class, 'checkPaymentIntentByid']);
    Route::get('stripe/customer', [StripeController::class, 'stripeCustomer']);
    Route::get('stripe/balance', [StripeController::class, 'stripeBalance']);

