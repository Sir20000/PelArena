<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure application environment variables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting setup...');

        // Charger le contenu existant du fichier .env
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            $this->error('.env file does not exist!');
            return;
        }

        $envContent = File::get($envPath);

        // Fonction pour récupérer la valeur actuelle d'une variable
        $getEnvValue = function ($key) use ($envContent) {
            preg_match("/^{$key}=(.*)$/m", $envContent, $matches);
            return isset($matches[1]) ? trim($matches[1], '"') : null;
        };

        // Collecter les variables avec les valeurs existantes par défaut
        $dbConnection = $this->ask('Database connection (e.g., mysql)', $getEnvValue('DB_CONNECTION'));
        $dbHost = $this->ask('Database host (e.g., 127.0.0.1)', $getEnvValue('DB_HOST'));
        $dbPort = $this->ask('Database port (e.g., 3306)', $getEnvValue('DB_PORT'));
        $dbName = $this->ask('Database name', $getEnvValue('DB_DATABASE'));
        $dbUsername = $this->ask('Database username', $getEnvValue('DB_USERNAME'));

        // Gestion du mot de passe avec conservation de la valeur existante si entrée vide
        $currentPassword = $getEnvValue('DB_PASSWORD');
        $dbPassword = $this->secret('Database password (will be hidden) [' . ($currentPassword ? '*****' : 'not set') . ']');
        $dbPassword = $dbPassword ?: $currentPassword;

        $pteroApiUrl = $this->ask('Pterodactyl API URL', $getEnvValue('PTERODACTYL_API_URL'));


        $currentKey = $getEnvValue('PTERODACTYL_API_KEY');
        $pteroApiKey = $this->secret('Pterodactyl API Key (will be hidden) [' . ($currentPassword ? '*****' : 'not set') . ']');
        $pteroApiKey = $dbPassword ?: $currentKey; 


        $appName = $this->ask('Application name', $getEnvValue('APP_NAME'));
        $appUrl = $this->ask('Application URL', $getEnvValue('APP_URL'));

        // Mettre à jour le fichier .env
        $this->updateEnv([
            'DB_CONNECTION' => $dbConnection,
            'DB_HOST' => $dbHost,
            'DB_PORT' => $dbPort,
            'DB_DATABASE' => $dbName,
            'DB_USERNAME' => $dbUsername,
            'DB_PASSWORD' => $dbPassword,
            'PTERODACTYL_API_URL' => $pteroApiUrl,
            'PTERODACTYL_API_KEY' => $pteroApiKey,
            'APP_NAME' => $appName,
            'APP_URL' => $appUrl,
        ]);

        $this->info('Setup completed successfully!');
    }

    /**
     * Update the .env file with new variables.
     *
     * @param array $data
     */
    private function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}=\"{$value}\"";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        File::put($envPath, $envContent);
    }
}
