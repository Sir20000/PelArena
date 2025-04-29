<?php
namespace App\Extensions;

class ExtensionManager
{
    /**
     * @var array<string, array{
     *   class: string,
     *   name: string,
     *   author: string,
     *   version: string,
     *   description: string
     * }>
     */
    protected static array $extensions = [];

    /**
     * Retourne l'instance d'un provider
     */
    public static function load(string $provider)
    {
        if (empty(self::$extensions)) {
            self::discoverExtensions();
        }

        if (! isset(self::$extensions[$provider])) {
            \Log::info("L'extension [$provider] n'est pas enregistrée.");
            throw new \Exception("Provider '$provider' non trouvé.");
        }

        $class = self::$extensions[$provider]['class'];
        $instance = new $class;

        // Appelle boot() au moment du chargement
        if (method_exists($instance, 'boot')) {
            $instance->boot();
        }

        return $instance;
    }

    /**
     * Scanne /extensions, lit extension.json, instancie et boot()
     */
    protected static function discoverExtensions(): void
    {
        $path = base_path('extensions');

        foreach (scandir($path) as $folder) {
            if (in_array($folder, ['.', '..'], true)) {
                continue;
            }

            $extensionDir = $path . DIRECTORY_SEPARATOR . $folder;
            if (! is_dir($extensionDir)) {
                continue;
            }

            // clé = 'pterodactyl'
            $providerKey = strtolower(str_replace('Extension', '', $folder));
            // classe = \Extensions\PterodactylExtension\PterodactylProvider
            $class = "\\Extensions\\{$folder}\\" . str_replace('Extension', 'Provider', $folder);

            if (! class_exists($class)) {
                \Log::warning("Classe {$class} introuvable pour l'extension {$providerKey}.");
                continue;
            }

            // métadonnées par défaut
            $meta = [
                'class'       => $class,
                'name'        => ucfirst($providerKey),
                'author'      => 'Non défini',
                'version'     => 'Non défini',
                'description' => 'Aucune description',
            ];

            // tente de lire extension.json
            $metaFile = $extensionDir . DIRECTORY_SEPARATOR . 'extension.json';
            if (file_exists($metaFile) && $json = json_decode(file_get_contents($metaFile), true)) {
                $meta['name']        = $json['name']        ?? $meta['name'];
                $meta['author']      = $json['author']      ?? $meta['author'];
                $meta['version']     = $json['version']     ?? $meta['version'];
                $meta['description'] = $json['description'] ?? $meta['description'];
            }

            // instancie et boot() pour enregistrer les champs
            $instance = new $class;
            if (method_exists($instance, 'boot')) {
                $instance->boot();
            }

            self::$extensions[$providerKey] = $meta;
            \Log::info("Extension {$providerKey} enregistrée avec la classe {$class} et metadata.");
        }
    }

    /**
     * Retourne toutes les extensions (métadonnées + class)
     * Utilisée pour la liste admin
     */
    public static function getExtensions(): array
    {
        if (empty(self::$extensions)) {
            self::discoverExtensions();
        }
        return self::$extensions;
    }
}
