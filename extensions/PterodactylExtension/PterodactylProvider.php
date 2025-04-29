<?php
namespace Extensions\PterodactylExtension;

use App\Extensions\ExtensionManager;
use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;

class PterodactylProvider
{

    public $author = 'Cyril';
    public $version = '1.0.0';
    public $description = 'Extension pour gérer les serveurs Pterodactyl.';

    public function boot(): void
{
    ExtensionField::register('pterodactyl', [
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

    public function createServer(array $data)
    {
        // Code pour créer un serveur sur Pterodactyl
        return "Serveur créé sur Pterodactyl.";
    }

    public function deleteServer(string $serverId)
    {
        // Code pour supprimer un serveur
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
            'server_name' => 'text', 
            'memory' => 'number',
            'cpu' => 'number',
            'disk' => 'number',
        ];
    }
    public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur
        return [
            'memory' => 'number',
            'cpu' => 'number',
            'disk' => 'number',
            "egg_id" => "number"
        ];
    }
}
