<?php

namespace App\Providers;

use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('category-view', [CategoryPolicy::class, 'view']);
        Gate::define('category-create', [CategoryPolicy::class, 'create']);
        Gate::define('category-update', [CategoryPolicy::class, 'update']);
        Gate::define('category-delete', [CategoryPolicy::class, 'delete']);

        Gate::define('post-create', [PostPolicy::class, 'create']);
        Gate::define('post-update', [PostPolicy::class, 'update']);
        Gate::define('post-delete', [PostPolicy::class, 'delete']);

        Gate::define('user-pagination', [UserPolicy::class, 'pagination']);
        Gate::define('user-view', [UserPolicy::class, 'view']);
        Gate::define('user-create', [UserPolicy::class, 'create']);
        Gate::define('user-update', [UserPolicy::class, 'update']);
        
    }
}
