<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServerOrder;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

use function Psy\debug;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('settings', 'name');


        return view('admin.dashboard', compact("settings"));
    }
    public function update(Request $request){

        // Validation
        $request->validate([
            'APP_NAME' => 'required|string|max:255',
            'APP_URL' => 'required|url|max:255',
            'seo'=> 'required|string|max:255',

            'tva' => 'required|integer|min:0|max:100',
            'affiliationget' => 'required|integer|min:0',
            'affiliationrecived' => 'required|integer|min:0',
            'tos' => 'required|string',
            'legal' => 'required|string',
            'privacypolitique' => 'required|string',
            'deleteafterpending' => 'required|integer|min:0',
'alert_status' => 'nullable|integer|min:0|max:1',

            "alert_color_bg"=> "required|string",
            "alert_color_text"=> "required|string",
            "alert_color_data"=> "required|string",
            "alert_color_icon"=> "required|string",
            'webhook_ticket'=> 'required|string',
            
        ]);

        // Récupérer la valeur `env` depuis la base de données


        // Mise à jour des valeurs dans la base de données
        DB::table('settings')->updateOrInsert(['name' => 'APP_NAME'], ['settings' => $request->APP_NAME]);
        DB::table('settings')->updateOrInsert(['name' => 'APP_URL'], ['settings' => $request->APP_URL]);

        DB::table('settings')->updateOrInsert(['name' => 'tva'], ['settings' => $request->tva]);
        DB::table('settings')->updateOrInsert(['name' => 'affiliationget'], ['settings' => $request->affiliationget]);
        DB::table('settings')->updateOrInsert(['name' => 'affiliationrecived'], ['settings' => $request->affiliationrecived]);
        DB::table('settings')->updateOrInsert(['name' => 'tos'], ['settings' => $request->tos]);
        DB::table('settings')->updateOrInsert(['name' => 'legal'], ['settings' => $request->legal]);
        DB::table('settings')->updateOrInsert(['name' => 'privacypolitique'], ['settings' => $request->privacypolitique]);

        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_MODE'], ['settings' => $request->PAYPAL_MODE]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_SANDBOX_CLIENT_ID'], ['settings' => $request->PAYPAL_SANDBOX_CLIENT_ID]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_SANDBOX_CLIENT_SECRET'], ['settings' => $request->PAYPAL_SANDBOX_CLIENT_SECRET]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_SANDBOX_APP_ID'], ['settings' => $request->PAYPAL_SANDBOX_APP_ID]);

        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_LIVE_CLIENT_ID'], ['settings' => $request->PAYPAL_LIVE_CLIENT_ID]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_LIVE_CLIENT_SECRET'], ['settings' => $request->PAYPAL_LIVE_CLIENT_SECRET]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_LIVE_APP_ID'], ['settings' => $request->PAYPAL_LIVE_APP_ID]);

        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_LOCALE'], ['settings' => $request->PAYPAL_LOCALE]);
        DB::table('settings')->updateOrInsert(['name' => 'PAYPAL_CURRENCY'], ['settings' => $request->PAYPAL_CURRENCY]);

        DB::table('settings')->updateOrInsert(['name' => 'deleteafterpending'], ['settings' => $request->deleteafterpending]);

        DB::table('settings')->updateOrInsert(['name' => 'alert_status'], ['settings' => $request->alert_status]);
        DB::table('settings')->updateOrInsert(['name' => 'alert_color_bg'], ['settings' => $request->alert_color_bg]);
        DB::table('settings')->updateOrInsert(['name' => 'alert_color_text'], ['settings' => $request->alert_color_text]);
        DB::table('settings')->updateOrInsert(['name' => 'alert_color_data'], ['settings' => $request->alert_color_data]);
        DB::table('settings')->updateOrInsert(['name' => 'alert_color_icon'], ['settings' => $request->alert_color_icon]);
        DB::table('settings')->updateOrInsert(['name' => 'seo'], ['settings' => $request->seo]);
        DB::table('settings')->updateOrInsert(['name' => 'webhook_ticket'], ['settings' => $request->webhook_ticket]);

        // Si `env` est égal à 1, mettre à jour le fichier `.env`
        $this->updateEnv([
            'APP_NAME' => $request->APP_NAME,
            'APP_URL' => $request->APP_URL,
            'PAYPAL_MODE' => $request->PAYPAL_MODE,
            'PAYPAL_SANDBOX_CLIENT_ID' => $request->PAYPAL_SANDBOX_CLIENT_ID,
            'PAYPAL_SANDBOX_CLIENT_SECRET' => $request->PAYPAL_SANDBOX_CLIENT_SECRET,
            'PAYPAL_SANDBOX_APP_ID' => $request->PAYPAL_SANDBOX_APP_ID,
            'PAYPAL_LIVE_CLIENT_ID' => $request->PAYPAL_LIVE_CLIENT_ID,
            'PAYPAL_LIVE_CLIENT_SECRET' => $request->PAYPAL_LIVE_CLIENT_SECRET,
            'PAYPAL_LIVE_APP_ID' => $request->PAYPAL_LIVE_APP_ID,
            'PAYPAL_CURRENCY' => $request->PAYPAL_CURRENCY,
            'PAYPAL_LOCALE' => $request->PAYPAL_LOCALE,
        ]);


        return redirect()->route('admin.dashboard.index')->with('success', 'Paramètres mis à jour avec succès.');
    }
    private function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            foreach ($data as $key => $value) {
                file_put_contents($envPath, preg_replace(
                    "/^{$key}=.*$/m",
                    "{$key}=\"{$value}\"",
                    file_get_contents($envPath)
                ));
            }
        }

        // Recharger les variables d'environnement
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        $base_path = base_path();
        $result = Process::run('cd ' . $base_path . ' && composer dump-autoload');
    }
    
}
