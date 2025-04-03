<?php

namespace App\Providers;

use App\Services\FormValidationService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FormValidationService::class, function ($app) {
            return new FormValidationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enable query logging in development environment
        if (app()->environment('local')) {
            DB::enableQueryLog();
        }
    }
}
