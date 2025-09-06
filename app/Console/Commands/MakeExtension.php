<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeExtension extends Command
{
    protected $signature = 'make:extension {name}';
    protected $description = 'Créer une nouvelle extension vide avec les fichiers de base';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $slug = Str::lower($name);
        $basePath = base_path("extensions/{$name}");

        if (File::exists($basePath)) {
            $this->error("L'extension \"{$name}\" existe déjà.");
            return 1;
        }

        // Création des dossiers nécessaires
        File::makeDirectory($basePath, 0755, true);
        File::makeDirectory("{$basePath}/css", 0755, true);
        File::makeDirectory("{$basePath}/js", 0755, true);
        File::makeDirectory("{$basePath}/routes", 0755, true);
        File::makeDirectory("{$basePath}/views", 0755, true);

        // Contenu des fichiers
        $extensionPhp = <<<PHP
<?php

namespace Extensions\\{$name};

use App\Models\ExtensionConfig;
use App\Extensions\ExtensionField;

class {$name}
{
    public \$author = 'Your name Bro';
    public \$version = '1.0.0';
    public \$description = 'Description de l’extension.';
    public \$util = 'server';

    public function boot(): void
    {
        \$fields = [
        [
                'key' => 'key',
                'type' => 'text',
                'label' => 'My best key baby',
                'default' => 'defaut valeur'
            ],
            [
                'key' => 'key2',
                'type' => 'password',
                'label' => 'The gay text label',
                'default' => '' 
            ],
            ];
        ExtensionField::register(strtolower('{$name}'), \$fields);

        foreach (\$fields as \$field) {
            ExtensionConfig::firstOrCreate(
                ['extension' => strtolower('{$name}'), 'key' => \$field['key']],
                ['value' => \$field['default'] ?? '']
            );
        }
    }

    public function getConfig(string \$key, \$default = null)
    {
        return ExtensionConfig::where('extension', strtolower('{$name}'))
            ->where('key', \$key)
            ->value('value') ?? \$default;
    }

    public function setConfig(string \$key, \$value): void
    {
        ExtensionConfig::updateOrCreate(
            ['extension' => strtolower('{$name}'), 'key' => \$key],
            ['value' => \$value]
        );
    }
    public function testConfig(){

    return true;
    
    }
    public function createUser(array \$data){
    return true;
    
    }
    public function createServer(array \$data){
        return true;

    }
public function deleteServer(array \$data){
    return true;

}
    public function suspendServer(array \$serverId){
        return true;

    }
 public function unsuspendServer(array \$serverId){
     return true;

    }
      public function getFieldsNeeded(): array
    {
        // Retourne les champs nécessaires pour créer un serveur (partie client PAS ADMIN) option et select ne sont pas implemente attendez ça arrive
        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (GIB)'],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)'],
            'disk' => ["type" => 'number', 'name' => 'Disk (GIB)'],
            'db' => ["type" => 'number', 'name' => 'Database'],
            'port' => ["type" => 'number', 'name' => 'Allocations'],
            'backups' => ["type" => 'number', 'name' => 'Backups '],
        ];
    }
         public function getFieldsCategorieNeeded(): array
    {
        // Retourne les champs nécessaires pour créer une Categorie select est implemente mais pas option :>
        return [
            'ram' => ["type" => 'number', 'name' => 'RAM (GIB)', "information" => false, "icon" => "ri-ram-line"],
            'cpu' => ["type" => 'number', 'name' => 'CPU (Core)', "information" => false, "icon" => "ri-cpu-line"],
            'disk' => ["type" => 'number', 'name' => 'Disk (GIB)', "information" => false, "icon" => "ri-hard-drive-3-line"],
            'db' => ["type" => 'number', 'name' => 'Database', "information" => false, "icon" => "ri-database-2-line"],
            'port' => ["type" => 'number', 'name' => 'Allocations', "information" => false, "icon" => "ri-door-line"],
            'backups' => ["type" => 'number', 'name' => 'Backups ', "information" => false, "icon" => "ri-instance-line"],
            'egg_id' => ["type" => 'select', 'name' => 'Egg', "information" => true, "icon" => "ri-file-line", 'options' => \$this->ARRAYFONCTION()],

        ];
    }
    public function index()
    {
        return view("extensions.{$name}::dashboard");
    }
}
PHP;

        $extensionJson = <<<JSON
{
    "name": "{$name}",
    "author": "your name Bro",
    "version": "1.0.0",
    "description": "Description de l’extension."
    
}
JSON;

        $adminPhp = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n// Routes admin ici\n \$categorie = 'Manage';\n\$icon = 'ri-terminal-line';\nRoute::get('/', [{$name}::class, 'index', ])->name('index');";
        $userPhp = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\n// Routes utilisateur ici\n";
        $dashboardBlade = "<h1>Extension {$name} : dashboard</h1>";
        $css = "/* CSS de l'extension {$name} */\n";
        $js = "// JS de l'extension {$name}\n";

        // Écriture des fichiers
        File::put("{$basePath}/{$name}.php", $extensionPhp);
        File::put("{$basePath}/extension.json", $extensionJson);
        File::put("{$basePath}/routes/admin.php", $adminPhp);
        File::put("{$basePath}/routes/user.php", $userPhp);
        File::put("{$basePath}/views/dashboard.blade.php", $dashboardBlade);
        File::put("{$basePath}/css/app.css", $css);
        File::put("{$basePath}/js/app.js", $js);

        $this->info("Extension \"{$name}\" créée avec succès !");
        return 0;
    }
}
