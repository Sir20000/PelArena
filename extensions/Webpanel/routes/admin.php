<?php

use Illuminate\Support\Facades\Route;

// Routes admin ici
 $categorie = 'Manage';
$icon = 'ri-terminal-line';
Route::get('/', [Webpanel::class, 'index', ])->name('index');