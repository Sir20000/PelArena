<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Clients\NewsController;

use App\Http\Middleware\Ensure2FAEnabled;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckUserDisabled;
Route::get('/', [NewsController::class, 'index', ])->name('welcome');

Route::view('/terms', 'terms', ['tos' => settings("tos")])->name('terms');
Route::view('/privacy', 'privacy', ['privacypolitique' => settings("privacypolitique")])->name('privacy');
Route::view('/legal', 'legal', ['legal' => settings("legal")])->name('legal');

Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

Route::middleware(['auth', CheckUserDisabled::class,Ensure2FAEnabled::class])->group(function () {

    require __DIR__ . '/user.php';
   
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->middleware(['auth', RoleMiddleware::class], CheckUserDisabled::class)->group(function () {

    require __DIR__ . '/admin.php';
});
