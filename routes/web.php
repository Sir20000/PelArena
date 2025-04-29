<?php

use Illuminate\Support\Facades\Route;


use App\Http\Middleware\Ensure2FAEnabled;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckUserDisabled;
use App\Http\Middleware\ApiMiddleware;



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
