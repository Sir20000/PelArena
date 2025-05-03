<?php

use Illuminate\Support\Facades\Route;
use Extensions\PterodactylExtension\Test;
$categorie = "Manage";
$icon = "ri-terminal-line";


Route::get('/', [Test::class, 'index', ])->name('index');
