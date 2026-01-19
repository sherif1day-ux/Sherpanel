<?php

namespace App\Providers;

use App\Services\ModuleLoader;
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
        $loader = new \App\Services\ModuleLoader();
        $loader->loadRoutes();
    }
}
