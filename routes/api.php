<?php

use App\Http\Controllers\Api\StripeController;
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

Route::group(['middleware' => 'auth:sanctum','as' => 'api.',], function () {
    Route::resource('category', App\Http\Controllers\Api\CategoryController::class)->except(["create", "edit", "index"]);
    Route::resource('post', App\Http\Controllers\Api\PostController::class)->except(["create", "edit", "index"]);
});
Route::group(['as' => 'api.',], function () {
 Route::resource('category', App\Http\Controllers\Api\CategoryController::class)->only(["index"]);
 Route::resource('post', App\Http\Controllers\Api\PostController::class)->only(["index"]);
});

Route::post('user/login',[App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('user/logout/{tokenId}',[App\Http\Controllers\Api\UserController::class, 'logout']);

// stripe
Route::get('stripe/create-session/{priceId}/{successURL?}/{cancelUrl?}', [StripeController::class, 'createSession']);
Route::get('stripe/get-session/{sessionId}', [StripeController::class, 'checkPayment']);
Route::get('stripe/get-payment-intent/{paymentIntentId}', [StripeController::class, 'checkPaymentIntentByid']);
Route::get('stripe/customer', [StripeController::class, 'stripeCustomer']);
Route::get('stripe/balance', [StripeController::class, 'stripeBalance']);