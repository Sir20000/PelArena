<?php

namespace App\Http\Controllers\Clients;

use App\Models\ServerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prix;
use App\Models\Categories;
use App\Http\Controllers\Utils\PterodactylController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\ServerPurchased;
use Illuminate\Support\Facades\Mail;
use App\Extensions\ExtensionManager;
use Illuminate\Support\Facades\Auth;

class ServersController extends Controller
{


    public function createOrder(Request $request, $categorie)
    {
        $categorie = Categories::all()->where('id', $categorie)->first();
        if(!$categorie){
abort(404);
        }
        log::debug($categorie);

        if ($categorie->stock == 0) {

            return redirect()->route('client.servers.index');
        }
        $provider = ExtensionManager::load('pterodactyl');

        $request->validate([
            'server_name' => 'required|string',
            'ram' => 'required|integer',
            'cpu' => 'required|integer',
            'disk' => 'required|integer',
            'db' => 'required|integer',
            'allocations' => 'required|integer',
            'backups' => 'required|integer',

        ]);
        $egg_id = $categorie->egg_id;
        // Créer une commande de serveur
        if ($request->ram > $categorie->maxram) {
            return redirect()->back()->with('error', 'La RAM demandée dépasse la limite autorisée');
        }

        if ($request->cpu > $categorie->maxcpu) {
            return redirect()->back()->with('error', 'Le nombre de CPU demandé dépasse la limite autorisée');
        }

        if ($request->disk > $categorie->maxstorage) {
            return redirect()->back()->with('error', 'Le stockage demandé dépasse la limite autorisée');
        }

        if ($request->db > $categorie->maxdb) {
            return redirect()->back()->with('error', 'Le nombre de bases de données demandé dépasse la limite autorisée');
        }

        if ($request->backups > $categorie->maxbackups) {
            return redirect()->back()->with('error', 'Le nombre de backups demandé dépasse la limite autorisée');
        }
        $prix = Prix::all()->where('categories_id', $categorie->id)->first();
        log::debug($prix);
        $prix_ram = $request->ram * $prix->ram;
        $prix_cpu = $request->cpu * $prix->cpu;
        $prix_disk = $request->disk * $prix->disk;
        $prix_db = $request->db * $prix->db;
        $prix_allocations = $request->allocations * $prix->allocations;
        $prix_backups = $request->backups * $prix->backups;
        $total = $prix_ram + $prix_cpu + $prix_disk + $prix_db +
            $prix_allocations + $prix_backups;

            $taux =settings("tva");
            $total_tva = $total * $taux / 100;
            $total = $total + $total_tva;
            $total = round($total, 2);
        $order = ServerOrder::create([
            'cost' => $total,

            'user_id' => Auth::id(),
            'server_name' => $request->server_name,
            'status' => 'pending',
            'ram' => $request->ram,
            'cpu' => $request->cpu,
            'storage' => $request->disk,
            'db' => $request->db,
            'backups' => $request->backups,
            'allocations' => $request->allocation + 1,
            'categorie' => $categorie->name,


        ]);
        $docker = PterodactylController::EggDetail($egg_id)["attributes"]["docker_image"];
       $startup = PterodactylController::EggDetail($egg_id)["attributes"]["startup"];
        // Utiliser l'API Pterodactyl pour créer le serveur
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post(env('PTERODACTYL_API_URL') . '/api/application/servers', [
            'name' => $request->server_name,
            'user' => Auth::user()->PterodactylId(),
            'egg' => $egg_id,
            'docker_image' =>  $docker,
            'startup' => $startup,
            'environment' => [
                'MINECRAFT_VERSION' => 'latest',
                'SERVER_JARFILE' => 'server.jar',
                'BUILD_NUMBER' => 'latest',
                'USER_UPLOAD' => 0,
                'MAIN_FILE' => 'index.js',
                'PY_FILE' => 'app.py',
                'AUTO_UPDATE' => 0,
                'REQUIREMENTS_FILE' => 'requirements.txt',


            ],
            'limits' => [
                'memory' => $request->ram * 1024,
                'swap' => 0,
                'cpu' => $request->cpu * 100,
                'io' => 500,
                'disk' =>  $request->disk * 1024,
            ],
            'feature_limits' => [
                'databases' => $request->db,
                'backups' =>  $request->backups,
                'allocations' => $request->allocation + 1,
            ],
            'allocation' => [
                'default' => PterodactylController::getFreeAllocation(PterodactylController::getNodeWithLeastAllocatedRam($categorie)),
            ],
        ]);

        log::debug($response);
        if ($response->successful()) {

            $serverId = $response->json()['attributes']['id'];  // Récupérer l'ID du serveur créé
            // Suspendre immédiatement le serveur
            $order->update(['server_id' => $serverId]);
            $suspendResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/suspend", []);
          
            if ($categorie->stock !== -1) {
                $categorie->stock = $categorie->stock - 1;
                $categorie->save();
            }
                        return redirect()->route('client.servers.index')->with('success', 'Commande de serveur réussie !');
            
        }

        $order->update(['status' => 'cancelled']);
        return redirect()->route('client.servers.index')->with('error', 'Échec de la commande du serveur.');
    }

    public function index(Request $request)
{
    // Requête de base
    $query = ServerOrder::where('user_id', Auth::id())
        ->orderBy('status', 'asc');

    // Appliquer un filtre de recherche si nécessaire
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('server_name', 'like', '%' . $request->search . '%')
              ->orWhere('categorie', 'like', '%' . $request->search . '%');
        });
    }

    // Récupérer les résultats paginés
    $orders = $query->paginate(10);

    return view('client.servers.index', compact('orders'));
}

    public function categorie()
    {
        $categories = Categories::all();
        return view('client.categories.index', compact('categories'));
    }
    public function orders(Request $request, $a)
    {
        $categorie = Categories::where('name', $a)->first();
        if(!$categorie){
            abort(404);
                    }
        $server = ServerOrder::where('categorie', $categorie->name)->count();

        
        if ($categorie) {
            if ($categorie->maxbyuser == 0 || $server <= $categorie->maxbyuser) {
                if ($categorie->stock == 0){
                    return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez pas commandé dans cette catégorie. Cette catégorie est hors stock');

                }
            $prix = Prix::all()->where('categories_id', $categorie->id)->first();
            $tva = settings("tva");
            return view('client.servers.orders.index', compact('categorie', 'prix','tva'));
            } else {
                return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez plus commandé dans cette catégorie.');
            }

        } else {
            return redirect()->route('client.servers.orders')->with('error', 'La catégorie n\'existe pas.');
        }
    }
    public function power(Request $request, $product)
    {
        CheckProduct($product->id);

        $server = PterodactylController::idtoindentifier($product);

        $url = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $server . '/power';

        $signal = $request->input('status');

        if (!in_array($signal, ['start', 'stop', 'restart', 'kill'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid action'], 400);
        }

        $payload = [
            'signal' => $signal
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY_CLIENT'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        return response()->json(['status' => 'success', 'message' => 'Action performed successfully']);
    }
    public function createBackup(Request $request, ServerOrder $product)
    {

        CheckProduct($product->id);

        $server = PterodactylController::idtoindentifier($product->id);

        $url = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $server . '/backups';
        $response = PterodactylController::postRequestClient($url, [
            'name' => 'Backup-' . now()->toDateTimeString(),
            'ignored_files' => []
        ]);
        $status = $response->status();
        
        if ($status == 200) {
            return response()->json(['status' => 'success', 'message' => 'Backup created successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to create backup']);
        }
    }

    public function downloadBackup(Request $request, ServerOrder $product, $backupId)
    {

        CheckProduct($product->id);

        $server = PterodactylController::idtoindentifier($product->id);
        $url = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $server . '/backups/' . $backupId . '/download';

        $response = PterodactylController::getRequestClient($url);

        if ($response->status() == 200) {
            return response()->json(['status' => 'success', 'download_url' => $response->json()['attributes']['url']]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to download backup'], $response->status());
        }
    }
    public function restoreBackup(Request $request, ServerOrder $product, $backupId)
    {
        CheckProduct($product->id);

        $server = PterodactylController::idtoindentifier($product->id);
        $url = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $server . '/backups/' . $backupId . '/restore';

        $response = PterodactylController::postRequestClient($url, ['truncate' => true]);

        if ($response->status() == 204) {
            return response()->json(['status' => 'success', 'message' => 'Backup restored successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to restore backup'], $response->status());
        }
    }


    public function deleteBackup(Request $request, ServerOrder $product, $backupId)
    {

        CheckProduct($product->id);
        $server = PterodactylController::idtoindentifier($product->id);
        $url = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $server . '/backups/' . $backupId;

        $response =  PterodactylController::deleteRequestClient($url);

        if ($response->status() == 204) {
            return response()->json(['status' => 'success', 'message' => 'Backup deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete backup'], $response->status());
        }
    }
}
