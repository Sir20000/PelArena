<?php
namespace App\Extensions;
use Illuminate\Support\Facades\Cache;

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
        \Log::info("Extensions enregistrées : " . print_r(self::$extensions, true));

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
    // Si les extensions sont en cache, les charger directement
    $cached = Cache::get('extensions_metadata');
    if ($cached !== null) {
        self::$extensions = $cached;
        \Log::info("Extensions chargées depuis le cache.");
        return;
    }

    $path = base_path('extensions');
    $extensions = [];

    foreach (scandir($path) as $folder) {
        if (in_array($folder, ['.', '..'], true)) {
            continue;
        }

        $extensionDir = $path . DIRECTORY_SEPARATOR . $folder;
        if (! is_dir($extensionDir)) {
            continue;
        }

        $providerKey = strtolower(str_replace('Extension', '', $folder));
        $class = "\\Extensions\\{$folder}\\" . str_replace('Extension', '', $folder);

        if (! class_exists($class)) {
            \Log::warning("Classe {$class} introuvable pour l'extension {$providerKey}.");
            continue;
        }

        $meta = [
            'class'       => $class,
            'name'        => ucfirst($providerKey),
            'author'      => 'Non défini',
            'version'     => 'Non défini',
            'description' => 'Aucune description',
        ];

        $metaFile = $extensionDir . DIRECTORY_SEPARATOR . 'extension.json';
        if (file_exists($metaFile) && $json = json_decode(file_get_contents($metaFile), true)) {
            $meta['name']        = $json['name']        ?? $meta['name'];
            $meta['author']      = $json['author']      ?? $meta['author'];
            $meta['version']     = $json['version']     ?? $meta['version'];
            $meta['description'] = $json['description'] ?? $meta['description'];
        }

        $instance = new $class;
        if (method_exists($instance, 'boot')) {
            $instance->boot();
        }

        $fields = method_exists($instance, 'getFieldsCategorieNeeded') ? $instance->getFieldsCategorieNeeded() : [];

        $meta['fileds'] = $fields;
        $extensions[$providerKey] = $meta;

        \Log::info("Extension {$providerKey} enregistrée avec la classe {$class} et metadata.");
    }

    // Stockage dans la propriété + cache
    self::$extensions = $extensions;
    Cache::forever('extensions_metadata', $extensions);
    \Log::info("Extensions mises en cache.");
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
    public static function getAdminMenuExtensions(): array
    {
        $path = base_path('extensions');
        $menus = [];
        
        foreach (scandir($path) as $folder) {
            if (in_array($folder, ['.', '..'], true)) {
                continue;
            }
        
            $adminRoutePath = $path . "/$folder/routes/admin.php";
            if (!file_exists($adminRoutePath)) {
                continue;
            }
    
            $fileContent = file_get_contents($adminRoutePath);
    
           // $categorie = 'Custom Extensions';
           // $icon = 'ri-terminal-line';
            
            if (preg_match('/\$categorie\s*=\s*"(.*?)";/', $fileContent, $matches)) {
                $categorie = $matches[1]; // Assigne la valeur trouvée
            }else{
                continue;
            }
    
            if (preg_match('/\$icon\s*=\s*"(.*?)";/', $fileContent, $matches)) {
                $icon = $matches[1]; // Assigne la valeur trouvée
            }else{
                continue;
            }
    
            $menus[$categorie][$folder] = [
                'route' => "admin.$folder.index", 
                'label' => ucfirst($folder),
                'icon' => $icon,
                'categorie' => $categorie
            ];
        }
    
        return $menus;
    }
    public static function executeOnAllExtensions(callable $callback): void
{
    if (empty(self::$extensions)) {
        self::discoverExtensions();
    }

    foreach (self::$extensions as $key => $extension) {
        $class = $extension['class'];

        if (!class_exists($class)) {
            \Log::warning("Classe {$class} introuvable pour l'extension {$key}.");
            continue;
        }

        $instance = new $class;

        $callback($instance, $key); // exécute la fonction donnée
    }
}
}
