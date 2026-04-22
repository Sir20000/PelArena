<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\ExtensionField;
use App\Models\ExtensionConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Extensions\ExtensionManager;
use Illuminate\Support\Facades\Log;
class ExtensionConfigController extends Controller
{
    public function index($extension)
    {
        // Appelle boot() + enregistre les champs via load()
        $provider = ExtensionManager::load($extension);
    
        // Récupère les champs dynamiques
        $fields = ExtensionField::getFields($extension);
    
        if (empty($fields)) {
            abort(404, "L'extension [$extension] n'a pas de champs définis.");
        }
    
        $values = ExtensionConfig::where('extension', $extension)
                    ->pluck('value', 'key')->toArray();
    
        return view('admin.extensions.config', compact('extension','fields','values'));
    }
    
    public function save(Request $request, $extension)
    {
        $provider = ExtensionManager::load($extension);

        $fields = ExtensionField::getFields($extension);

        foreach ($fields as $field) {
            $value = $request->input($field['key']);
            ExtensionConfig::updateOrCreate(
                ['extension' => $extension, 'key' => $field['key']],
                ['value' => $value]
            );
        }
        $test=$provider->testConfig();
if ($test){
        return redirect()->back()->with('success', 'Configuration enregistrée.');
    }else{
        return redirect()->back()->with('error', 'Configuration invalide.');

    }
    }
}
