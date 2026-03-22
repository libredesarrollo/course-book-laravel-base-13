<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');

// Rutas de Perfil (accesibles para cualquier usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['prefix' => 'dashboard', 'middleware'=> ['auth',App\Http\Middleware\UserIsAdminMiddleware::class]], function () {
    Route::resources([
        'post' => PostController::class,
        'category' => CategoryController::class,
    ]);
});
