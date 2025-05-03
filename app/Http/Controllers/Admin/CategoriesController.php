<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\ExtensionManager;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\PterodactylController;

use App\Models\Prix;
use App\Models\Categories;
use App\Models\ServerOrder;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    
    public function index()
    {
        $categories = Categories::all();
    
        return view('admin.categorie.index', compact('categories'));
    }
    
    /**
     * Affiche le formulaire pour créer un nouveau admin.prix.
     */
    public function create()

    {
        $extensions = ExtensionManager::getExtensions();

        return view('admin.categorie.create', compact('extensions'));
    }
    
    /**
     * Enregistre un nouveau admin.prix.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable', // Ajout de la validation pour l'image
            'maxbyuser' => 'required|integer',
            'stock' => 'required|integer',
            'extension'=>'required|string|max:255',
            'max' => 'required|array',
        'prix' => 'required|array',
        'info' => 'required|array',

        ]);
        foreach ($request->input('max') as $index => $value) {
            $customFields['max'][$index] = $value;
        }
    
        foreach ($request->input('prix') as $index => $value) {
            $customFields['prix'][$index] = $value;
        }
        foreach ($request->input('info') as $index => $value) {
            $customFields['info'][$index] = $value;
        }
        $validatedData['extension'] = $request->input('extension');

        // Ajouter le champ custom_fields au modèle
        $validatedData['extension_fields'] = json_encode($customFields);
    
        $category = Categories::create($validatedData);
       
       
        return redirect()->route('admin.categorie.index')->with('success', 'Prix ajouté avec succès.');
    }
    
    /**
     * Affiche un prix spécifique.
     */

    
    
    /**
     * Affiche le formulaire pour modifier un admin.prix.
     */
    public function edit(Categories $id)
    {
    $server = ServerOrder::where("categorie",$id->name)->get();
    $extensions = ExtensionManager::getExtensions();
    $fields = json_decode($id->extension_fields, true);


        return view('admin.categorie.edit', compact('id','server','extensions','fields'));
    }
    /**
     * Met à jour un prix existant.
     */
    public function update(Request $request, Categories $id)
    {

        $category = Categories::findOrFail($id->id);

        $validatedData = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable', // Ajout de la validation pour l'image
            'maxbyuser' => 'required|integer',
            'stock' => 'required|integer',
            'max' => 'required|array',
        'prix' => 'required|array',
        'info' => 'required|array',
    
    ]);
        foreach ($request->input('max') as $index => $value) {
            $customFields['max'][$index] = $value;
        }
    
        foreach ($request->input('prix') as $index => $value) {
            $customFields['prix'][$index] = $value;
        }
        foreach ($request->input('info') as $index => $value) {
            $customFields['info'][$index] = $value;
        }
        $validatedData['extension'] = $request->input('extension');

        $validatedData['extension_fields'] = json_encode($customFields);
        $category->update($validatedData);
        
              

        return redirect()->route('admin.categorie.index')->with('success', 'category mis à jour avec succès.');
    }
    
    
    /**
     * Supprime un admin.prix.
     */
    public function destroy(Categories $id)
    {
        $id->delete();
    
        return redirect()->route('admin.categorie.index')->with('success', 'Prix supprimé avec succès.');
    }
}

