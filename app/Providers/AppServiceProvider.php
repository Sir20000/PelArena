<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
        // Compteur de requêtes SQL (facultatif)
        app()->singleton('queryCount', function () {
            return 0;
        });

        DB::listen(function ($query) {
            app()->instance('queryCount', app()->make('queryCount') + 1);
        });

        // Charger dynamiquement les fichiers JS/CSS des extensions
        View::composer('*', function ($view) {
            $extensionsPath = base_path('extensions');
            $assets = [];

            if (is_dir($extensionsPath)) {
                foreach (scandir($extensionsPath) as $ext) {
                    if (in_array($ext, ['.', '..'])) continue;

                    $jsPath = base_path("extensions/$ext/js/app.js");
                    $cssPath = base_path("extensions/$ext/css/app.css");

                    if (file_exists($jsPath)) {
                        $assets[] = "extensions/$ext/js/app.js";
                    }

                    if (file_exists($cssPath)) {
                        $assets[] = "extensions/$ext/css/app.css";
                    }
                }
            }

            $view->with('extensionAssets', $assets);
        });
    }
}
