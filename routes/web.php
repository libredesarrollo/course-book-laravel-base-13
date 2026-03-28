<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Pruebas\CourseController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Middleware\LanguagePrefixMiddleware;
use App\Http\Middleware\UserIsAdminMiddleware;
use App\Jobs\TestJob;
use App\Models\User;
use App\View\Components\Dashboard\role\permission\Manage as RoleManage;
use App\View\Components\Dashboard\user\role\permission\Manage as UserManage;
use Illuminate\Support\Facades\Route;

// WELCOME
Route::get('/', function () {
    return view('welcome', ['name' => 'John ']);
})->name('home');

// PRUEBAS
Route::get('/blade', [CourseController::class, 'index'])->middleware(LanguagePrefixMiddleware::class);

// QUEUE AND JOBS
Route::get('/test-job', function () {
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
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', UserIsAdminMiddleware::class]], function () {
    Route::resources([
        'post' => PostController::class,
        'category' => CategoryController::class,
        'role' => RoleController::class,
        'permission' => PermissionController::class,
        'user' => UserController::class,
    ]);

    // // roles - permissions
    // Route::post('role/assign/permission/{role}', [App\View\Components\Dashboard\role\permission\Manage::class, 'handle'])->name('role.assign.permission');
    // Route::delete('role/delete/permission/{role}', [App\View\Components\Dashboard\role\permission\Manage::class, 'delete'])->name('role.delete.permission');
    // Route::post('role/delete/permission/{role}', [App\View\Components\Dashboard\role\permission\Manage::class, 'delete'])->name('role.delete.permission');

    // // user - roles - permissions
    // Route::post('user/assign/role/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'handleRole'])->name('user.assign.role');
    // Route::delete('user/delete/role/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'deleteRole'])->name('user.delete.role');
    // Route::post('user/delete/role/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'deleteRole'])->name('user.delete.role');
    // //permissions
    // Route::post('user/assign/permission/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'handlePermission'])->name('user.assign.permission');
    // Route::delete('user/delete/permission/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'deletePermission'])->name('user.delete.permission');
    // Route::post('user/delete/permission/{user}', [App\View\Components\Dashboard\user\role\permission\Manage::class, 'deletePermission'])->name('user.delete.permission');

    // Grupo para Roles y sus Permisos
    Route::prefix('role')->name('role.')->group(function () {
        Route::post('assign/permission/{role}', [RoleManage::class, 'handle'])->name('assign.permission');

        // Agrupamos el delete/post de eliminación bajo el mismo endpoint
        Route::match(['delete', 'post'], 'delete/permission/{role}', [RoleManage::class, 'delete'])->name('delete.permission');
    });

    // Grupo para Usuarios, sus Roles y Permisos
    Route::prefix('user')->name('user.')->group(function () {

        // Subgrupo para Roles de usuario
        Route::prefix('role')->group(function () {
            Route::post('assign/{user}', [UserManage::class, 'handleRole'])->name('assign.role');
            Route::match(['delete', 'post'], 'delete/{user}', [UserManage::class, 'deleteRole'])->name('delete.role');
        });

        // Subgrupo para Permisos de usuario
        Route::prefix('permission')->group(function () {
            Route::post('assign/{user}', [UserManage::class, 'handlePermission'])->name('assign.permission');
            Route::match(['delete', 'post'], 'delete/{user}', [UserManage::class, 'deletePermission'])->name('delete.permission');
        });
    });

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

// STRIPE (protegidas por auth)
Route::middleware('auth')->group(function () {
    Route::get('/stripe/set-payment-method', function () {
        return view('stripe.payment-method', ['intent' => auth()->user()->createSetupIntent()]);
    });

    Route::get('/stripe/get-payment-method', function () {
        dd(auth()->user()->paymentMethods());
    });

    Route::get('/stripe/delete-payment-method', function () {
        auth()->user()->deletePaymentMethods();
    });

    Route::get('/stripe/create-payment-intent', function () {
        $payment = auth()->user()->pay(100);

        return view('stripe.payment-confirm', ['clientSecret' => $payment->client_secret]);
    });

    Route::get('/stripe/new-subcription', function () {
        dd(
            auth()->user()->newSubscription(
                'default2',
                'price_1QYPNDCWud7Ri9mJPPPtwAnj'
            )->quantity(3)
                ->create('pm_1Qh7GJCWud7Ri9mJr1sC38w8')
        );
    });

    Route::get('/stripe/is-subcribed', function () {
        dd(auth()->user()->subscription('default')->ended());
    });
});
