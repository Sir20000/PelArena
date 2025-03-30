<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user and synchronize with Pterodactyl API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new user...');

        // Collecter les informations de l'utilisateur
        $name = $this->ask('Name');
        $email = $this->ask('Email');

        // Vérifier si l'email est unique dans la base de données
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists in the database!');
            return;
        }

        $password = $this->secret('Password (hidden input)');
        $confirmPassword = $this->secret('Confirm Password');

        // Vérification des mots de passe
        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return;
        }

        $role = $this->ask('Role (default: user (1) ,admin (2))', '1');

        // Récupérer les configurations API
        $key = env('PTERODACTYL_API_KEY');
        $url = env('PTERODACTYL_API_URL');

        if (empty($key) || empty($url)) {
            $this->error('Missing API configuration. Please check your .env file or run php artisan app:setup.');
            return;
        }

        // Créer l'utilisateur dans Pterodactyl
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url . '/api/application/users', [
            'username' => $name,
            'email' => $email,
            'first_name' => '#0000',
            'last_name' => $name,
            'password' => $password,
        ]);

        // Vérifier le statut de la réponse de l'API
        if ($response->status() === 201) {
            $pteroUser = $response->json()['attributes'];
            $this->info('User created successfully in Pterodactyl.');

            // Enregistrer l'utilisateur dans la base de données locale
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'pterodactyl_user_id' => $pteroUser['id'], // Assurez-vous que cette colonne existe
            ]);

            if ($user) {
                $this->info('User successfully created locally and synchronized with Pterodactyl.');
            } else {
                $this->error('Failed to save user locally.');
            }
        } else {
            $this->error('Failed to create user in Pterodactyl.');
            Log::error('Pterodactyl API Error: ' . $response->body());
        }
    }
}
