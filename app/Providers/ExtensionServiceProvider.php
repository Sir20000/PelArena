<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckUserDisabled;
use App\Http\Middleware\ApiMiddleware;

class ExtensionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $extensionPath = base_path('extensions');

        if (!File::isDirectory($extensionPath)) {
            return;
        }

        $directories = File::directories($extensionPath);

        foreach ($directories as $extensionDir) {
            $extension = basename($extensionDir);

            // Load views
            $viewsPath = $extensionDir . '/views';
            if (File::exists($viewsPath)) {
                $namespace = "extensions.$extension";
                $this->loadViewsFrom($viewsPath, $namespace);
    
            } 

            // Admin routes
            $adminRoutes = $extensionDir . '/routes/admin.php';
            if (File::exists($adminRoutes)) {
                Route::middleware(['web', RoleMiddleware::class, CheckUserDisabled::class])
                    ->name("admin.$extension.")
                    ->prefix("admin/$extension")
                    ->group($adminRoutes);
            } 

            // User routes
            $userRoutes = $extensionDir . '/routes/user.php';
            if (File::exists($userRoutes)) {
                Route::middleware(['web', 'auth', CheckUserDisabled::class])
                    ->name("client.$extension.")
                    ->prefix("$extension")
                    ->group($userRoutes);
            } 

            // API routes
            $apiRoutes = $extensionDir . '/routes/api.php';
            if (File::exists($apiRoutes)) {
                Route::middleware([ApiMiddleware::class])
                    ->name("api.$extension.")
                    ->prefix("$extension")
                    ->group($apiRoutes);
            } 
        }

    }
}
