<?php

use Illuminate\Support\Facades\Route;
use Extensions\Proxmox\Proxmox;

// Routes admin ici
$categorie = 'Manage';
$icon = 'ri-terminal-line';
Route::get('/', [Proxmox::class, 'index', ])->name('index');