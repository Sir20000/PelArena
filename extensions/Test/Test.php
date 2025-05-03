<?php

namespace Extensions\Test;

use App\Extensions\ExtensionManager;
use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;

use Illuminate\Support\Facades\Http;

class Test
{

    public $author = 'Cyril';
    public $version = '1.0.0';
    public $description = 'Extension pour gérer les serveurs Test.';
    public $util = 'server';
    public function boot(): void
    {
        ExtensionField::register('Test', [
            [
                'key' => 'api_url',
                'type' => 'text',
                'label' => 'API URL'
            ],
            [
                'key' => 'api_token',
                'type' => 'password',
                'label' => 'API Token'
            ],
        ]);
    }
    public function getConfig(string $key, $default = null)
    {
        return ExtensionConfig::where('extension', 'pterodactyl')
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public function setConfig(string $key, $value): void
    {
        ExtensionConfig::updateOrCreate(
            [
                'extension' => 'pterodactyl',
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

    public function createServer(array $data)
    {

        return "Serveur créé sur Pterodactyl.";
    }

    public function deleteServer(string $serverId)
    {
        return "Serveur $serverId supprimé de Pterodactyl.";
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

    public function getFieldsNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur
        return [
            'name' => ["type" => 'text','name'=>'Server name'],
            'ram' => ["type" => 'number','name'=>'RAM (GIB).....'],
            'cpu' => ["type" => 'number','name'=>'CPU (Core)'],
            'disk' => ["type" => 'number','name'=>'Disk (GIB)'],
            'db' => ["type" => 'number','name'=>'Database'],
            'port' => ["type" => 'number','name'=>'Allocations'],
            'backups' => ["type" => 'number','name'=>'Backups '],
        ];
    }
    public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur
        return [
            'name' => ["type" => 'text','name'=>'Server name'],
            'ram' => ["type" => 'number','name'=>'RAM (GIB)'],
            'cpu' => ["type" => 'number','name'=>'CPU (Core)'],
            'disk' => ["type" => 'number','name'=>'Disk (GIB)'],
            'db' => ["type" => 'number','name'=>'Database'],
            'port' => ["type" => 'number','name'=>'Allocations'],
            'backups' => ["type" => 'number','name'=>'Backups '],
            'egg_id' => ["type" => 'number','name'=>'Backups '],

        ];
    }
    public function index()
    {
        return view("extensions.PterodactylExtension::dashboard");
    }
}
