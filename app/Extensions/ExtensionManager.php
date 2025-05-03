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
        $path = base_path('extensions');

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
            $fileds = $instance->getFieldsCategorieNeeded();
           
            self::$extensions[$providerKey] = $meta;
            self::$extensions[$providerKey]["fileds"] = $fileds;

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
    
            $categorie = 'Custom Extensions';
            $icon = 'ri-terminal-line';
            
            if (preg_match('/\$categorie\s*=\s*"(.*?)";/', $fileContent, $matches)) {
                $categorie = $matches[1]; // Assigne la valeur trouvée
            }
    
            if (preg_match('/\$icon\s*=\s*"(.*?)";/', $fileContent, $matches)) {
                $icon = $matches[1]; // Assigne la valeur trouvée
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
