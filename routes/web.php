<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Pruebas\CourseController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Middleware\LanguagePrefixMiddleware;
use App\Jobs\SendSubscribeEmailJob;
use App\Jobs\TestJob;
use App\Mail\SubscribeEmail;
use App\Models\Post;
use App\View\Components\Blog\Post\Detail;
use Illuminate\Support\Facades\Route;

// WELCOME
Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');

// PRUEBAS
Route::get('/blade', [CourseController::class, 'index'])->middleware(LanguagePrefixMiddleware::class);

// QUEUE AND JOBS
Route::get('/test-job',function(){
    // SendSubscribeEmailJob::dispatch(auth()->user());
    TestJob::dispatch()->onQueue('culeables'); // COLCA CON NOMBRE php artisan queue:work --queue=culeables

    return 'Super vista';
});

// PERFIL (accesibles para cualquier usuario autenticado)
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
});

// VUE
Route::get('/vue/{n1?}/{n2?}/{n3?}', function () {
    return view('vue');
});
