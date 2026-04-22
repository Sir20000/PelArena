<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('api.users.index');
    Route::get('/{id}', [UsersController::class, 'show'])->name('api.users.show');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('api.users.edit');
    Route::get('/{id}/delete', [UsersController::class, 'destroy'])->name('api.users.destroy');

    Route::post('/{id}/update', [UsersController::class, 'update'])->name('api.users.update');
});
