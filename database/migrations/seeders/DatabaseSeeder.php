<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultSettings = [
            
            ['name' => 'APP_NAME', 'settings' => 'My Application', 'env' => 1],
            ['name' => 'APP_URL', 'settings' => 'http://example.com', 'env' => 1],
            ['name' => 'PTERODACTYL_API_URL', 'settings' => 'https://api.example.com', 'env' => 1],
            ['name' => 'PTERODACTYL_API_KEY', 'settings' => 'your_api_key', 'env' => 1],
            ['name' => 'tva', 'settings' => '0', 'env' => 0],
            ['name' => 'affiliationget', 'settings' => '5', 'env' => 0],
            ['name' => 'affiliationrecived', 'settings' => '5', 'env' => 0],
            ['name' => 'tos', 'settings' => 'Voici nos conditions...', 'env' => 0],
            ['name' => 'privacypolitique', 'settings' => '5', 'env' => 0],
            ['name' => 'legal', 'settings' => 'Raison Sociale : Nom de votre entreprise

Siège Social : 123 Rue Exemple, 75000 Paris, France

SIRET : 123 456 789 00012

Numéro de TVA : FR123456789012

Directeur de la publication : Prénom Nom

Contact : email@example.com

Numéro de téléphone : 01 23 45 67 89

Hébergeur : OVH, 2 Rue Kellermann, 59100 Roubaix, France', 'env' => 0],

['name' => 'PTERODACTYL_API_KEY_CLIENT', 'settings' => 'your_api_key_client', 'env' => 1],
['name' => 'PAYPAL_MODE', 'settings' => 'live', 'env' => 1],
['name' => 'PAYPAL_SANDBOX_CLIENT_ID', 'settings' => 'clientid', 'env' => 1],
['name' => 'PAYPAL_SANDBOX_CLIENT_SECRET', 'settings' => 'secretclient', 'env' => 1],
['name' => 'PAYPAL_SANDBOX_APP_ID', 'settings' => 'liveappid', 'env' => 1],


['name' => 'PAYPAL_LIVE_CLIENT_ID', 'settings' => 'clientid', 'env' => 1],
['name' => 'PAYPAL_LIVE_CLIENT_SECRET', 'settings' => 'secretclient', 'env' => 1],
['name' => 'PAYPAL_LIVE_APP_ID', 'settings' => 'liveappid', 'env' => 1],

['name' => 'PAYPAL_CURRENCY', 'settings' => 'EUR', 'env' => 1],
['name' => 'PAYPAL_LOCALE', 'settings' => 'fr_FR', 'env' => 1],
['name' => 'deleteafterpending', 'settings' => 21, 'env' => 0],
['name'=> 'reqquet','settings'=>0,"env" =>0],
['name'=> 'INVISIBLE_RECAPTCHA_SITEKEY','settings'=>'6LcJcjwUAAAAAO_Xqjrtj9wWufUpYRnK6BW8lnfn',"env" =>0],
['name'=> 'INVISIBLE_RECAPTCHA_SECRETKEY','settings'=>'6LcJcjwUAAAAALOcDJqAEYKTDhwELCkzUkNDQ0J5',"env" =>0],
['name'=> 'alert_status','settings'=>1,"env"=>0],
['name'=> 'alert_color_bg','settings'=>"red-500","env"=>0],
['name'=> 'alert_color_text','settings'=>"white","env"=>0],
['name'=> 'alert_color_data','settings'=>"O","env"=>0],
['name'=> 'alert_color_icon','settings'=>"ri-information-line","env"=>0],

];
        $defaultCategoriTicket = [
            ['name' => 'Facturation', 'priority' => 'low',],
            ['name' => 'Bug', 'priority' => 'low'],
            ['name' => 'Support Technique', 'priority' => 'low'],


        ];
      
        echo "Seeder exécuté !\n";

        foreach ($defaultSettings as $setting) {
            $exists = DB::table('settings')->where('name', $setting['name'])->exists();

            if (!$exists) {
                DB::table('settings')->insert([
                    'name' => $setting['name'],
                    'settings' => $setting['settings'],
                    'env' => $setting['env'],
                ]);
                echo $setting['name'] . " a été ajouté.\n";
            } else {
                echo $setting['name'] . " existe déjà, aucune action effectuée.\n";
            }
        }
        foreach ($defaultCategoriTicket as $cat) {
            $existsdefaultCategoriTicket = DB::table('categories_tickets')->where('name', $cat['name'])->exists();

            if (!$existsdefaultCategoriTicket) {
                DB::table('categories_tickets')->insert([
                    'name' => $cat['name'],
                    'priority' => $cat['priority'],

                ]);
                echo $cat['name'] . " a été ajouté.\n";
            } else {
                echo $cat['name'] . " existe déjà, aucune action effectuée.\n";
            }
        }
    }
}
