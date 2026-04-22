<?php

use Illuminate\Support\Facades\Route;

use Extensions\Pelican\Pelican;



Route::get('/managerserver', [Pelican::class, 'managerserver', ])->name('managerserver');
