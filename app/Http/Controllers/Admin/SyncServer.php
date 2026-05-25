<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServerOrder;
use App\Extensions\ExtensionManager;
class SyncServer extends Controller
{
    /**
     * Apeler sync de tout avec le serveur selon lextention
     */
    public function index()
    {
        $serversData = ServerOrder::all();
            ExtensionManager::executeOnAllExtensions(function ($instance, $key) use ($serversData) {
    if (method_exists($instance, 'Sync')) {
        try {
            $instance->createUser($userData);

            \Log::info("Méthode createUser exécutée pour l'extension {$key}");
        } catch (\Throwable $e) {
            \Log::error("Erreur dans createUser pour l'extension {$key} : {$e->getMessage()}", [
                'exception' => $e,
            ]);
        }
    }
            });
    }

    /**
     * Mettre à jour les paramètres.
     */
  
}
