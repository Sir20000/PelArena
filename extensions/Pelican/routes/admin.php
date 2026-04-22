<?php

use Illuminate\Support\Facades\Route;
use Extensions\Pelican\Pelican;
$categorie = "Manage";
$icon = "ri-terminal-line";


Route::get('/', [Pelican::class, 'index', ])->name('index');
