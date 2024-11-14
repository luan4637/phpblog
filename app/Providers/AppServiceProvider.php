<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Core\Category\CategoryRepositoryInterface::class,
            \App\Core\Category\CategoryRepository::class
        );

        $this->app->singleton(
            \App\Core\Post\PostRepositoryInterface::class,
            \App\Core\Post\PostRepository::class
        );

        $this->app->singleton(
            \App\Core\User\UserRepositoryInterface::class,
            \App\Core\User\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Database\Eloquent\Factories\Factory::useNamespace('App\\');
        
    }
}
