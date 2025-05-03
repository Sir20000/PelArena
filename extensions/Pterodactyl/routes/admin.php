<?php

use Illuminate\Support\Facades\Route;
use Extensions\PterodactylExtension\Pterodactyl;
$categorie = "Manage";
$icon = "ri-terminal-line";


Route::get('/', [Pterodactyl::class, 'index', ])->name('index');
