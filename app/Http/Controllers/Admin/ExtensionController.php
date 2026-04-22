<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Extensions\ExtensionManager;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        // Charge toutes les extensions disponibles via ExtensionManager
        $extensions = ExtensionManager::getExtensions();

        // Retourne la vue avec la liste des extensions
        return view('admin.extensions.index', compact('extensions'));
    }
}
