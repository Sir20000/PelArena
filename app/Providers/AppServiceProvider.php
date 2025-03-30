<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
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
        app()->singleton('queryCount', function () {
            return 0; // Initialisation du compteur à 0
        });
    
        DB::listen(function ($query) {
            app()->instance('queryCount', app()->make('queryCount') + 1);
        });
    }
}
