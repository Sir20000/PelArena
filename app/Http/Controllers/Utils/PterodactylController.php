<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PterodactylController extends Controller
{
    public static function getNodeWithLeastAllocatedRam($name)
    {
        $url = env('PTERODACTYL_API_URL') . '/api/application/nodes';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->get($url);
        $name = $name->name;
        $nodes = $response->json()['data'];
        $leastRamNode = null;
        $leastRamAllocated = PHP_INT_MAX;
        
        foreach ($nodes as $node) {
    
            $ramAllocated = $node['attributes']['allocated_resources']['memory'] ?? 0;
            $tags = $node['attributes']['tags'] ?? [];
    
            // Vérifie si l'un des tags contient le nom passé en paramètre
            foreach ($tags as $tag) {

                if ($tag == $name) {
    
                    // Si oui, on vérifie si ce nœud a le moins de RAM allouée
                    if ($ramAllocated < $leastRamAllocated) {
                        $leastRamAllocated = $ramAllocated;
    
                        $leastRamNode = $node;
                    }
                    break;  // Sort de la boucle dès qu'une correspondance est trouvée
                }
            }
        }
        return $leastRamNode['attributes']['id'] ?? null;
    }
 
    

    public static function getFreeAllocation($node)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Accept' => 'application/json',
        ])->get(env('PTERODACTYL_API_URL') . '/api/application/nodes/' . $node . '/allocations?per_page=500');
        log::debug($response);

        if ($response->successful()) {
            $allocations = $response->json()['data'];

            $freeAllocation = null;

            foreach ($allocations as $allocation) {
                if ($allocation['attributes']['assigned'] === false) {
                    $freeAllocation = $allocation['attributes']["id"];
                    break;
                }
            }

            if ($freeAllocation) {
                return $freeAllocation;
            } else {
            }
        } else {
        }
    }
    public static function EggDetail($egg_id)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Accept' => 'application/json',
        ])->get(env('PTERODACTYL_API_URL') . '/api/application/eggs/' . $egg_id . '?per_page=500');
        if ($response->successful()) {
            $eggdetail = $response->json();
            return $eggdetail;
        }
        return null;
    }
    public static function GetlinkForServer($id){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Accept' => 'application/json',
        ])->get(env('PTERODACTYL_API_URL') . '/api/application/servers/' . $id);

        if ($response->successful()) {
            $data = $response->json(); 
            $url = env('PTERODACTYL_API_URL') . '/server/' . $data["attributes"]["id"]."/console";
            return $url;
        }
        return null;

    }
    public static function getNodes()
{
    $apiUrl = env('PTERODACTYL_API_URL') . '/api/application/nodes';
    $apiKey = env('PTERODACTYL_API_KEY');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Accept' => 'application/json',
    ])->get($apiUrl);

    if ($response->successful()) {
        return $response->json()['data'];
    }

    return [];
}
public static function idtoindentifier($product)
{
    $servera = \App\Models\ServerOrder::where('id', $product)->first();
    $server = $servera->server_id;
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->get(env('PTERODACTYL_API_URL'). '/api/application/servers/'.$server);
    $server = $response->json();

    $server = $server['attributes']['identifier'];
    return $server;
}
public static function postRequestClient($url, $data): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
   

    return Http::withHeaders([
        'Authorization' => 'Bearer ' .env('PTERODACTYL_API_KEY_CLIENT'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->post($url, $data);
}




public static function getRequestClient($url): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY_CLIENT'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->get($url);
}

public static function deleteRequestClient($url): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY_CLIENT'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->delete($url);
}

public static function postRequest($url, $data): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->post($url, $data);
}

public static function patchRequest($url, $data): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->patch($url, $data);
}

public static function getRequest($url): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->get($url);
}

public static function deleteRequest($url): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
{
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ])->delete($url);
}
}
