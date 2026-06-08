<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServerOrder;
use App\Extensions\ExtensionManager;
use Illuminate\Support\Facades\Log;
class SyncServer extends Controller
{
    /**
     * Apeler sync de tout avec le serveur selon lextention
     */
    public function index()
    {
        $serversData = ServerOrder::with('product')->get()
    ->groupBy(fn ($server) => $server->product->extension);

ExtensionManager::executeOnAllExtensions(function ($instance, $key) use ($serversData) {

    // Vérifie si cette extension a des serveurs
    if (!isset($serversData[$key])) {
        return;
    }

    $servers = $serversData[$key];

    if (method_exists($instance, 'Sync')) {
        try {
            foreach ($servers as $server) {
                $instance->Sync($server); // ou createUser selon ton besoin
            }

            Log::info("Sync exécuté pour l'extension {$key}");
        } catch (\Throwable $e) {
            Log::error("Erreur Sync extension {$key} : {$e->getMessage()}", [
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
