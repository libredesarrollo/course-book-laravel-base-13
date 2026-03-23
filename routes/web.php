<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\User\ProfileController;
use App\Models\Post;
use App\View\Components\Blog\Post\Detail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');

// Rutas de Perfil (accesibles para cualquier usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// DASHBOARD
Route::group(['prefix' => 'dashboard', 'middleware'=> ['auth',App\Http\Middleware\UserIsAdminMiddleware::class]], function () {
    Route::resources([
        'post' => PostController::class,
        'category' => CategoryController::class,
    ]);
});

// BLOG
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{post}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('detail-component/{post}',[ App\View\Components\Blog\Post\Detail::class, 'render' ]);
    Route::get('detail-component-2/{post}',[ App\View\Components\Blog\Post\Detail::class, 'test_route' ]);

    Route::get('detail-component-3/{post}', function (Post $post) {
        // Instanciamos el componente pasándole el modelo Post
        return (new Detail($post))->render();
    })->name('c.blog.show');
});
