<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS en producción para generar URLs absolutas seguras detrás de proxy (Railway/Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
