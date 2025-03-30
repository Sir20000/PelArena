<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\ServerOrder;
use App\Http\Controllers\Utils\PterodactylController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ManagerServerController extends Controller
{

    public function index(ServerOrder $server)
    {
        $yourserver = \App\Models\ServerOrder::where("user_id", Auth::id())
            ->where('id', $server->id)
            ->get();
        if ($yourserver->isEmpty()) {
            abort(404);
        }
        $categorie = Categories::all()->where("name", $server->categorie)->first();
        $url =  PterodactylController::getLinkForServer($server->server_id);
        $serveriden = PterodactylController::idtoindentifier($server->id);
        $urltr = env('PTERODACTYL_API_URL') . '/api/client/servers/' . $serveriden . '/backups';

        $response = PterodactylController::getRequestClient($urltr);
        $status = $response->status();

        if ($response->status() == 200) {
            $var = $response->json()['meta']["pagination"];
            $max = $var["total"];
            $min = $var["count"];
            $backups = $response->json()['data'];


            return view('client.servers.manage.index', compact('server', 'categorie', 'url'))->with([
                'backups' => $backups,
                'clients' => 1,
                'nbr' =>  $min
            ]);
        }
    }
}
