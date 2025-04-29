<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Clients\ProfileController;
use App\Http\Controllers\Clients\ServersController;
use App\Http\Controllers\Clients\ManagerServerController;
use App\Http\Controllers\Clients\TicketsController;
use App\Http\Controllers\Clients\CouponController;
use App\Http\Controllers\Clients\DashboardController;
use App\Http\Controllers\Clients\CreditsController;
use App\Http\Controllers\Utils\PaymentController;
use App\Http\Controllers\Clients\NewsController;
use App\Http\Controllers\Clients\LegalController;
Route::get('/', [NewsController::class, 'index', ])->name('welcome');

Route::get('/terms', [LegalController::class , 'terms'])->name('terms');
Route::get('/privacy',[LegalController::class , 'privacy'] )->name('privacy');
Route::get('/legal', [LegalController::class , 'legal'])->name('legal');

Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('payment')->middleware(['auth'])->group(function () {
    Route::get('/{id}', [PaymentController::class, 'index'])->name('paypal.pay');
    Route::get('/credit/{id}', [PaymentController::class, 'credit'])->name('credit.buy');

    Route::get('/paypal/{id}/buy', [PaymentController::class, 'pay'])->name('paypal.pay.buy');
    Route::get('/paypal/success', [PaymentController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaymentController::class, 'cancel'])->name('paypal.cancel');

    Route::post('/apply-coupon/{order}', [CouponController::class, 'coupon'])->name('paypal.coupon');
});

Route::prefix('server')->middleware(['auth'])->group(function () {
    Route::get('/', [ServersController::class, 'index'])->name('client.servers.index');
    Route::get('/manage/{server}', [ManagerServerController::class, 'index'])->name('client.servers.manage');
    Route::get('/orders', [ServersController::class, 'categorie'])->name('client.servers.orders');
    Route::get('/orders/{categorie}', [ServersController::class, 'orders'])->name('client.servers.orders.categorie');
    Route::get('/manage/{server}/renouvel', [PaymentController::class, 'pay'])->name('client.servers.manage.renouvel');
    Route::get('/manage/{server}/cancel', [PaymentController::class, 'cancelp'])->name('client.servers.manage.cancel');

    Route::post('/order/create/{categorie}-', [ServersController::class, 'createOrder'])->name('client.servers.order.create');
    Route::post('/manage/{server}/power', [ServersController::class, 'power'])->name('client.servers.manage.power');
    Route::get('/manage/{product}/backups/{backupId}/download', [ServersController::class, 'downloadBackup'])->name('extensions.pterodactyl.backups.download');

    Route::post('/manage/{product}/backups/create', [ServersController::class, 'createBackup'])->name('extensions.pterodactyl.backups.create');
    Route::post('/manage/{product}/backups/{backupId}/restore', [ServersController::class, 'restoreBackup'])->name('extensions.pterodactyl.backups.restore');
    
    Route::delete('/manage/{product}/backups/{backupId}/delete', [ServersController::class, 'deleteBackup'])->name('extensions.pterodactyl.backups.delete');
    
});

Route::prefix('tickets')->middleware('auth')->group(function () {
    Route::get('/', [TicketsController::class, 'index'])->name('tickets.index');
    Route::get('/create', [TicketsController::class, 'create'])->name('tickets.create');
    Route::post('/store', [TicketsController::class, 'store'])->name('tickets.store');
    Route::get('/{ticketId}', [TicketsController::class, 'show'])->name('tickets.show');
    Route::post('/{ticketId}/message', [TicketsController::class, 'addMessage'])->name('tickets.message');
    Route::post('/{id}/close', [TicketsController::class, 'close'])->name('tickets.close');
});

Route::prefix('credit')->middleware(['auth'])->group(function () {
    Route::get('/paypal/success', [CreditsController::class, 'success'])->name('credit.paypal.success');
    Route::get('/paypal/cancel', [CreditsController::class, 'cancel'])->name('credit.paypal.cancel');

    Route::post('/', [CreditsController::class, 'index'])->name('credit.paypal');
});
