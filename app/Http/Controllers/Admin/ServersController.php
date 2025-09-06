<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServerOrder;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ServersController extends Controller
{
    public function index(Request $request)
{
    $query = ServerOrder::query(); // Remplace User par le modèle correspondant

    // Appliquer un filtre de recherche
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'like', '%' . $request->search . '%') // Recherche sur le nom
              ->orWhere('email', 'like', '%' . $request->search . '%'); // Ou sur l'email
    }

    // Récupérer les utilisateurs avec pagination
    $server = $query->paginate(20);
    return view('admin.servers.index', compact('server'));
}

/**
 * Affiche le formulaire pour créer un nouveau admin.prix.
 */


/**
 * Enregistre un nouveau admin.prix.
 */


/**
 * Affiche un prix spécifique.
 */
public function show(ServerOrder $id)
{
    return view('admin.servers.show', compact('id'));
}

/**
 * Affiche le formulaire pour modifier un admin.prix.
 */
public function edit(ServerOrder $id)
{
    $server = $id;
    return view('admin.servers.edit', compact('server'));
}

public function update(Request $request, ServerOrder $id)
{
    try {
        $request->merge(['enable' => $request->has('enable')]);

        // Validation des champs du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:pending,active,suspendu,cancelled',
            
        ]);
        // Mise à jour des données utilisateur
        $id->update($request->only([
            'name',
            'server_id',
            'status',
           
        ]));
        $serverId = $id->server_id;
        $currentStatus = $request->status;
    
        // Vérifie si le statut est 'active' ou non
        if ($currentStatus === 'active') {
            // Appel à l'API pour réactiver le serveur (unsuspend)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/unsuspend");
    
            if ($response->successful()) {
                // Mettre à jour le statut en base de données
                $id->update(['status' => 'active']);
            } else {
            }
        } else {
            // Appel à l'API pour suspendre le serveur
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/suspend");
    
            if ($response->successful()) {
                // Mettre à jour le statut en base de données
                $id->update(['status' => $currentStatus]);
            } else {
            }
        }

        // Redirection après mise à jour
        return redirect()->route('admin.servers.index')->with('success', 'Server mis à jour avec succès.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gestion des erreurs de validation
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        // Gestion des autres erreurs
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'utilisateur.')->withInput();
    }
}


/**
 * Supprime un admin.prix.
 */
public function destroy(ServerOrder $id)
{
    $id->delete();

    return redirect()->route('admin.servers.index')->with('success', 'Server supprimé avec succès.');
}
}
