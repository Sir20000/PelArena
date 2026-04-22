<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\Ensure2FAEnabled;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckUserDisabled;
use App\Http\Middleware\ApiMiddleware;
use App\Http\Controllers\Clients\NewsController;
use App\Http\Controllers\Clients\LegalController;

Route::get('/terms', [LegalController::class , 'terms'])->name('terms');
Route::get('/privacy',[LegalController::class , 'privacy'] )->name('privacy');
Route::get('/legal', [LegalController::class , 'legal'])->name('legal');

Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/', [NewsController::class, 'index', ])->name('welcome');


Route::middleware(['auth', CheckUserDisabled::class,Ensure2FAEnabled::class])->group(function () {

    require __DIR__ . '/user.php';
   
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->middleware(['auth', RoleMiddleware::class], CheckUserDisabled::class)->group(function () {

    require __DIR__ . '/admin.php';
});

Route::prefix('api')->middleware([ApiMiddleware::class])->group(function () {

    require __DIR__ . '/api.php';
});
