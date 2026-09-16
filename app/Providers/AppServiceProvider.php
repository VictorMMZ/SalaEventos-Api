<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ReservaAdmin;
use App\Observers\ReservaAdminObserver;

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
        ReservaAdmin::observe(ReservaAdminObserver::class);
    }
}