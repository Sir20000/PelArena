<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Afficher les paramètres.
     */
    public function index()
    {
        $settings = Settings::all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Mettre à jour les paramètres.
     */
  
}
