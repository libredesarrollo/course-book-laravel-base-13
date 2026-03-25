<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // prevenir el problema de N+1
        // Model::preventLazyLoading(!app()->isProduction());

        Vite::useScriptTagAttributes(
            [
                'async' => true
            ]
        );

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id == $post->user_id;
        // });


        // Gate::define('update-post', function(User $user, Post $post) {
        //     return $user->id == $post->user_id;
        // });

        //)

        // Gate::define('update-view-user-admin', function ($user, $userParams, $permissionName) {
        //     return ($user->hasRole('Admin') || !$userParams->hasRole('Admin')) && auth()->user()->hasPermissionTo($permissionName);
        // });
        // Gate::define('is-admin', function ($user) {
        //     return $user->hasRole('Admin');
        // });
    }
}
