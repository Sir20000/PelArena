<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ServersController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\ExtensionConfigController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\Admin\TicketsCategoriesController;


Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

Route::post('/', [DashboardController::class, 'update'])->name('admin.dashboard.update');


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoriesController::class, 'index'])->name('admin.categorie.index');
    Route::get('/create', [CategoriesController::class, 'create'])->name('admin.categorie.create');
    Route::get('/{id}', [CategoriesController::class, 'show'])->name('admin.categorie.show');
    Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('admin.categorie.edit');
    Route::get('/{id}/delete', [CategoriesController::class, 'destroy'])->name('admin.categorie.destroy');

    Route::post('/{id}/update', [CategoriesController::class, 'update'])->name('admin.categorie.update');
    Route::post('/store', [CategoriesController::class, 'store'])->name('admin.categorie.store');
});


Route::prefix('revenue')->group(function () {
    Route::get('/', [RevenueController::class, 'index'])->name('admin.revenue.index');
});

Route::prefix('coupons')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::get('/{coupon}', [CouponController::class, 'show'])->name('admin.coupons.show');
    Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    
    Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');
    
    Route::post('/{coupon}/update', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::post('/store', [CouponController::class, 'store'])->name('admin.coupons.store');
});

Route::prefix('categories_tickets')->group(function () {
    Route::get('/', [TicketsCategoriesController::class, 'index'])->name('admin.tickets.categorie.index');
    Route::get('/create', [TicketsCategoriesController::class, 'create'])->name('admin.tickets.categorie.create');
    Route::post('/store', [TicketsCategoriesController::class, 'store'])->name('admin.tickets.categorie.store');
    Route::get('/{id}/edit', [TicketsCategoriesController::class, 'edit'])->name('admin.tickets.categorie.edit');
    Route::post('/{id}/update', [TicketsCategoriesController::class, 'update'])->name('admin.tickets.categorie.update');
    Route::get('/{id}/delete', [TicketsCategoriesController::class, 'destroy'])->name('admin.tickets.categorie.destroy');
});

Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/{ticketId}', [TicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/{ticketId}/message', [TicketController::class, 'addMessage'])->name('admin.tickets.message');
    Route::post('/{id}/close', [TicketController::class, 'close'])->name('admin.tickets.close');
});


Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/{id}', [UsersController::class, 'show'])->name('admin.users.show');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('/{id}/delete', [UsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::post('/{id}/update', [UsersController::class, 'update'])->name('admin.users.update');
});

Route::prefix('servers')->group(function () {
    Route::get('/', [ServersController::class, 'index'])->name('admin.servers.index');
    Route::get('/{id}', [ServersController::class, 'show'])->name('admin.servers.show');
    Route::get('/{id}/edit', [ServersController::class, 'edit'])->name('admin.servers.edit');
    Route::get('/{id}/delete', [ServersController::class, 'destroy'])->name('admin.servers.destroy');

    Route::post('/{id}/update', [ServersController::class, 'update'])->name('admin.servers.update');
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('/destroy/{new}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
    Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');

    Route::post('/update/{id}', [NewsController::class, 'update'])->name('admin.news.update');

});

Route::prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'index'])->name('admin.roles.index');
    Route::get('/create', [RolesController::class, 'create'])->name('admin.roles.create');
    Route::post('/store', [RolesController::class, 'store'])->name('admin.roles.store');
    Route::get('/{id}/edit', [RolesController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/{id}/update', [RolesController::class, 'update'])->name('admin.roles.update');
    Route::delete('/{id}/delete', [RolesController::class, 'destroy'])->name('admin.roles.destroy');
});

Route::prefix('analyse')->group(function () {
    Route::get('/', [StatistiqueController::class, 'index'])->name('admin.statistique.index');
   
});

Route::prefix('api')->group(function () {
    Route::get('/', [ApiController::class, 'index'])->name('admin.api.index');
    Route::get('/create', [ApiController::class, 'create'])->name('admin.api.create');
    Route::get('/{id}', [ApiController::class, 'show'])->name('admin.api.show');
    Route::get('/{id}/edit', [ApiController::class, 'edit'])->name('admin.api.edit');
    Route::get('/{id}/delete', [ApiController::class, 'destroy'])->name('admin.api.destroy');

    Route::post('/{id}/update', [ApiController::class, 'update'])->name('admin.api.update');
    Route::post('/store', [ApiController::class, 'store'])->name('admin.api.store');
});
Route::get('/extensions/{extension}/config', [ExtensionConfigController::class, 'index'])->name('admin.extensions.config');

// Sauvegarder les changements
Route::post('/extensions/{extension}/config', [ExtensionConfigController::class, 'save'])->name('admin.extensions.config.save');
Route::get('/extensions', [ExtensionController::class, 'index'])->name('admin.extensions.index');
