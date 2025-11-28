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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('site_title', \App\Models\Setting::get('site_title', 'OIDB Panel'));
            $view->with('site_logo', \App\Models\Setting::get('site_logo'));
            $view->with('site_favicon', \App\Models\Setting::get('site_favicon'));
        });
    }
}
