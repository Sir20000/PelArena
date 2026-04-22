<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('updateEnv')) {
    /**
     * Update or add a key-value pair in the .env file.
     *
     * @param array $data Key-value pairs to update.
     * @return void
     */
    function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        // Vérifier si le fichier .env existe
        if (!File::exists($envPath)) {
            throw new \Exception('.env file does not exist.');
        }

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}=\"" . addslashes($value) . "\"";

            // Si la clé existe déjà, remplacer sa valeur
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // Sinon, ajouter la nouvelle clé à la fin
                $envContent .= "\n{$replacement}";
            }
        }

        // Écrire les modifications dans le fichier .env
        File::put($envPath, $envContent);
    }
}
if (!function_exists('settings')) {
    /**
     * Récupère une valeur depuis la table laravel.settings.
     *
     * @param string $key La clé du paramètre.
     * @param mixed $default La valeur par défaut si le paramètre n'existe pas.
     * @return mixed La valeur du paramètre ou la valeur par défaut.
     */
    function settings($key, $default = null)
    {
        // Utiliser le cache pour éviter des requêtes répétées
        $settings = DB::table('settings')->pluck('settings', 'name')->toArray();


        // Retourner la valeur correspondante ou la valeur par défaut
        return $settings[$key] ?? $default;
    }
}
if (!function_exists('format_number')) {
    function format_number($number)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M'; // Million
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'K'; // Mille
        }
        return $number;
    }
}
if (!function_exists('CheckProduct')) {
    function CheckProduct($id)
    {
        $yourserver = \App\Models\ServerOrder::where("user_id", Auth::id())
            ->where('id', $id)
            ->get();
        if ($yourserver->isEmpty()) {
            abort(404);
        }
    }
}
if (!function_exists('CheckTicket')) {
    function CheckTicket($id)
    {
        $yourserver = \App\Models\Ticket::where("user_id", Auth::id())
            ->where('id', $id)
            ->get();
        if ($yourserver->isEmpty()) {
            abort(404);
        }
    }
}
