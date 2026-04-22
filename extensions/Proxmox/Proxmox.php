<?php

namespace Extensions\Proxmox;

use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Proxmox
{
    public $author = 'Sir_200';
    public $version = '1.0.0';
    public $description = 'Description de l’extension.';
    public $util = 'server';

    public function boot(): void
    {
        $fields = [
           
            [
                'key' => 'host',
                'label' => 'Host',
                'type' => 'text',
                
            ],
            [
                'key' => 'port',
                'label' => 'Port',
                'type' => 'text',
                
            ],
            [
                'key' => 'username',
                'label' => 'Username',
                'type' => 'text',
                'default' => 'root@pam'
              
            ],
            [
                'key' => 'password',
                'label' => 'API Token',
                'type' => 'text',
                'default' => 'apitoken=aaaaaaaaa-bbb-cccc-dddd-ef0123456789'
                
            ]
        ];
        ExtensionField::register(strtolower('Proxmox'), $fields);

        foreach ($fields as $field) {
            ExtensionConfig::firstOrCreate(
                ['extension' => strtolower('Proxmox'), 'key' => $field['key']],
                ['value' => $field['default'] ?? '']
            );
        }
    }

    public function getConfig(string $key, $default = null)
    {
        return ExtensionConfig::where('extension', strtolower('Proxmox'))
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public function setConfig(string $key, $value): void
    {
        ExtensionConfig::updateOrCreate(
            ['extension' => strtolower('Proxmox'), 'key' => $key],
            ['value' => $value]
        );
    }

    public function testConfig()
    {
        $host = $this->getConfig('host');
        $port = $this->getConfig('port', 8006);
        $username = $this->getConfig('username');
        $token = $this->getConfig('password');
    
        $url = "https://$host:$port/api2/json/cluster/resources";
    
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => "PVEAPIToken=$username!$token"
            ])->get($url);
    
            \Log::debug('Proxmox API response:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);
    
            if ($response->successful()) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Proxmox API connection failed: ' . $e->getMessage());
            return false;
        }
    }
    

    public function createUser(array $data)
    {
        return true;
    }
    public function createServer(array $data)
    {
        return true;
    }
    public function deleteServer(array $data)
    {
        return true;
    }
    public function suspendServer(array $serverId)
    {
        return true;
    }
    public function unsuspendServer(array $serverId)
    {
        return true;
    }
    
private function gettemplate(): array
{
    $host = $this->getConfig('host');
    $port = $this->getConfig('port', 8006);
    $username = $this->getConfig('username');
    $token = $this->getConfig('password');

    $url = "https://$host:$port/api2/json/cluster/resources";

    try {
        $response = Http::withoutVerifying()->withHeaders([
            'Authorization' => "PVEAPIToken=$username!$token"
        ])->get($url);

        if (!$response->successful()) {
            \Log::error('Proxmox API reponse failed: ' . $e->getMessage());

            return [];
        }

        $data = $response->json()['data'];
        log::debug( $response);

        // Filtrer uniquement les VM avec le tag "template"
        $templates = collect($data)->filter(function ($vm) {
            return isset($vm['tags']) && str_contains($vm['tags'], 'template');
        })->map(function ($vm) {
            return [
                'id' => $vm['vmid'] ?? null,
                'name' => $vm['name'] ?? null,
            ];
        })->values()->toArray();
        return $templates;

    } catch (\Exception $e) {
        \Log::error('Proxmox API connection failed: ' . $e->getMessage());
        return [];
    }
}
    public function getFieldsNeeded($categorie): array
    {
        $templates = json_decode($categorie->extension_fields,true);
        // Retourne les champs nécessaires pour créer un serveur (partie client PAS ADMIN) option et select ne sont pas implemente attendez ça arrive
        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (GIB)'],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)'],
            'disk' => ["type" => 'number', 'name' => 'Disk (GIB)'],
            'template' => ["type" => 'select', 'name' => 'OS',"options"=>$templates["info"]["template"]],
            
        ];
    }
    public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer une Categorie select est implemente mais pas option :>
        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (GIB)', "information" => false, "icon" => "ri-ram-line"],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)', "information" => false, "icon" => "ri-cpu-line"],
            'disk' => ["type" => 'number', 'name' => 'Disk (GIB)', "information" => false, "icon" => "ri-hard-drive-3-line"],
            'template' => ["type" => 'select','multiple' => true, 'name' => 'Template ', "information" => true, "icon" => "ri-instance-line","options"=>$this->gettemplate()],

        ];
    }
    public function index()
    {
        return view("extensions.Proxmox::dashboard");
    }
}
