<?php

use Illuminate\Support\Facades\Route;
use Extensions\Webpanel\Webpanel;

// Routes admin ici
 $categorie = 'Web';
$icon = 'ri-terminal-line';
Route::get('/', [Webpanel::class, 'index', ])->name('index');