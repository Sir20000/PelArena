<?php

namespace Extensions\Pelican;

use App\Extensions\ExtensionManager;
use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;

use Illuminate\Support\Facades\Http;


use function Pest\Laravel\options;

class Pelican
{

    public $author = 'Sir_200';
    public $version = '1.0.0';
    public $description = 'Extension pour gérer les serveurs Pelican.';
    public $util = 'server';
    public function boot(): void
    {
        $fields = [
            [
                'key' => 'api_url',
                'type' => 'text',
                'label' => 'API URL',
                'default' => 'https://panel.example.com' // valeur par défaut
            ],
            [
                'key' => 'api_token',
                'type' => 'password',
                'label' => 'Admin API Token',
                'default' => '' // vide par défaut
            ], [
                'key' => 'client_api_token',
                'type' => 'password',
                'label' => 'Client API Token',
                'default' => '' // vide par défaut
            ],
        ];
    
        ExtensionField::register('pelican', $fields);
    
        foreach ($fields as $field) {
            ExtensionConfig::firstOrCreate(
                [
                    'extension' => 'pelican',
                    'key' => $field['key'],
                ],
                [
                    'value' => $field['default']?? '',
                ]
            );
        }
    }
    
    public function getConfig(string $key, $default = null)
    {
        return ExtensionConfig::where('extension', 'pelican')
            ->where('key', $key)
            ->value('value') ?? $default;
    }	

    public function setConfig(string $key, $value): void
    {
        ExtensionConfig::updateOrCreate(
            [
                'extension' => 'pelican',
                'key' => $key,
            ],
            [
                'value' => $value,
            ]
        );
    }
    public function testConfig()
    {

        $apiUrl = $this->getConfig('api_url') . "api/application/users";
        $apiToken = $this->getConfig('api_token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl);

        if ($response->successful()) {
            return true;
        }
        return false;
    }
    public function createUser(array $data)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getConfig('api_token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',

        ])->post($this->getConfig('api_url') . 'api/application/users', [
            'username' => $data["name"],
            'email' => $data["email"],
            'last_name' => $data["name"],
            'first_name' => '#0000',
            'password' => $data["password"],
        ]);
        if ($response->successful()) {
            return true;
        } else {
            return false;
        }
    }
    public function getNodeWithLeastAllocatedRam($name)
    {return 1;
        $url = $this->getConfig('api_url') . 'api/application/nodes';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->get($url);
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
 
    

    public function getFreeAllocation($node)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
            'Accept' => 'application/json',
        ])->get($this->getConfig('api_url') . 'api/application/nodes/' . $node . '/allocations');

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
    public function EggDetail($egg_id): array
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getConfig('api_token'),
            'Accept' => 'application/json',
        ])->get($this->getConfig('api_url') . 'api/application/eggs/' . $egg_id );
        if ($response->successful()) {
            $eggdetail = $response->json();
            return $eggdetail;
        }
        return [];
    }
    public  function GetlinkForServer($id){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getConfig('api_token'),
            'Accept' => 'application/json',
        ])->get($this->getConfig('api_url') . 'api/application/servers/' . $id);

        if ($response->successful()) {
            $data = $response->json(); 
            $url = $this->getConfig('api_url'). '/server/' . $data["attributes"]["id"]."/console";
            return $url;
        }
        return null;

    }
    public  function getNodes()
{
    $apiUrl = $this->getConfig('api_url'). 'api/application/nodes';
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
public  function idtoindentifier($product)
{
    $servera = \App\Models\ServerOrder::where('id', $product)->first();
    $server = $servera->server_id;
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->get($this->getConfig('api_url'). '/api/application/servers/'.$server);
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

public function Request(string $url, string $method = 'get', array $params = []): \Illuminate\Http\Client\Response
{
    $client = Http::withHeaders([
        'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
        'Accept' => 'Application/vnd.Pterodactyl.v1+json',
        'Content-Type' => 'application/json',
    ]);

    if (strtolower($method) === 'get') {
        return $client->get($url, $params);
    }

    if (strtolower($method) === 'post') {
        return $client->post($url, $params);
    }

    // Ajouter d'autres méthodes si besoin
    throw new \InvalidArgumentException("Méthode HTTP non supportée : $method");
}
    public function createServer(array $data)
    {
        $response = $this->Request($this->getConfig('api_url').'api/application/users', 'get', [
            'filter[email]' => $data["email"],
        ]);
        
        $userId = $response['data'][0]['attributes']['id'] ?? null;
        if (!$userId){
            return false;
        }
    
        $egg = $this->EggDetail($data["info"]["egg_id"]);
        $docker = $egg['attributes']['docker_image'];

        $startup = $egg['attributes']['startup'];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->getConfig('api_url') . 'api/application/servers', [
            'name' => $data["server_name"],
            'user' => $userId,
            'egg' => $data["info"]["egg_id"],
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
'VANILLA_VERSION'=>'latest'

            ],
            'limits' => [
                'memory' => $data["extension_fields"]["ram"] ,
                'swap' => 0,
                'cpu' => $data["extension_fields"]["cpu"],
                'io' => 500,
                'disk' => $data["extension_fields"]["disk"] ,
            ],
            'feature_limits' => [
                'databases' => $data["extension_fields"]["db"],
                'backups' =>  $data["extension_fields"]["backups"],
                'allocations' => $data["extension_fields"]["port"] + 1,
            ],
'deploy'=> [
'tags' => [$data['categorie']["name"]],
'dedicated_ip'=> false,
'port_range' =>[
"2025-3000"
]
]
            
        ]);
        if ($response->successful()) {
            return [
                "info" => [
                    "server_id" => $response->json()['attributes']['id']
                ]
            ];
        }else{

        }
        return false;    }

    public function deleteServer(array $serverId)
    {
         $id = $serverId["server_id"];
        $suspendResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->getConfig('api_url') . "api/application/servers/{$id}/delete", []);

        return true;
    }

    public function startServer(string $serverId)
    {
        // Code pour démarrer un serveur
        return "Serveur $serverId démarré sur Pterodactyl.";
    }

    public function stopServer(string $serverId)
    {
        // Code pour arrêter un serveur
        return "Serveur $serverId arrêté sur Pterodactyl.";
    }

    public function rebootServer(string $serverId)
    {
        // Code pour redémarrer un serveur
        return "Serveur $serverId redémarré sur Pterodactyl.";
    }

    public function getServerStatus(string $serverId)
    {
        // Code pour obtenir le statut d'un serveur
        return "Statut du serveur $serverId.";
    }
    public function suspendServer(array $serverId)
    {
        $id = $serverId["server_id"];
        $suspendResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' .$this->getConfig('api_token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->getConfig('api_url') . "api/application/servers/{$id}/suspend", []);

        return true;
    }

    public function unsuspendServer(array $serverId)
    {
        $id = $serverId["server_id"];

        $suspendResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getConfig('api_token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->getConfig('api_url') . "api/application/servers/{$id}/unsuspend", []);

        return true;
    }
    public function getEggs()
    {
        $apiUrl = $this->getConfig('api_url');
        $apiToken = $this->getConfig('api_token');
        try {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'api/application/eggs');

    } catch(\Exception $e){
    return null;
    }
        if ($response->successful()) {
            $data = $response->json();

            $eggs = [];

            foreach ($data['data'] as $egg) {
                $eggs[] = [
                    'id' => $egg['attributes']['id'],
                    'name' => $egg['attributes']['name'],
                ];
            }

            return $eggs;
        }
        return null;
        

    }
    public function getFieldsNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur

        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (MIB)'],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)'],
            'disk' => ["type" => 'number', 'name' => 'Disk (MIB)'],
            'db' => ["type" => 'number', 'name' => 'Database'],
            'port' => ["type" => 'number', 'name' => 'Allocations'],
            'backups' => ["type" => 'number', 'name' => 'Backups '],
        ];
    }
    public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un produit
        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (MIB)', "information" => false, "icon" => "ri-ram-line"],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)', "information" => false, "icon" => "ri-cpu-line"],
            'disk' => ["type" => 'number', 'name' => 'Disk (MIB)', "information" => false, "icon" => "ri-hard-drive-3-line"],
            'db' => ["type" => 'number', 'name' => 'Database', "information" => false, "icon" => "ri-database-2-line"],
            'port' => ["type" => 'number', 'name' => 'Allocations', "information" => false, "icon" => "ri-door-line"],
            'backups' => ["type" => 'number', 'name' => 'Backups ', "information" => false, "icon" => "ri-instance-line"],
            'egg_id' => ["type" => 'select', 'name' => 'Egg', "information" => true, "icon" => "ri-file-line", 'options' => $this->getEggs()],

        ];
    }
    public function index()
    {
        return view("extensions.Pelican::dashboard");
    }
      public function managerserver($server)
    {
$url =  $this->getConfig('api_url'); 
        return view("extensions.Pelican::managerserver",compact("server","url"));
    }
}
