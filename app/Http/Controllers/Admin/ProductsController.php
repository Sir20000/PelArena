<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Extensions\ExtensionManager;
use App\Models\ServerOrder;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
    
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Affiche le formulaire pour créer un nouveau admin.prix.
     */
    public function create()

    {
        $extensions = ExtensionManager::getExtensions();
        $categories = Categories::all();

        return view('admin.products.create', compact('extensions','categories'));
    }
    
    /**
     * Enregistre un nouveau admin.prix.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable', 
            'maxbyuser' => 'required|integer',
            'stock' => 'required|integer',
            'extension'=>'required|string|max:255',
            'config' => 'required|array',
        'price' => 'required|numeric',
        'info' => 'required|array',
        'categorie' => 'required|integer|min:0',

        ]);
        foreach ($request->input('config') as $index => $value) {
            $customFields['config'][$index] = $value;
        }
    
      
        foreach ($request->input('info') as $index => $value) {
            $customFields['info'][$index] = $value;
        }
        //$validatedData['extension'] = $request->input('extension');
       Log::debug($validatedData);

        // Ajouter le champ custom_fields au modèle
        $validatedData['extension_fields'] = json_encode($customFields);
           Log::debug($validatedData);

        $product = Product::create($validatedData);
       Log::debug($product);
       
        return redirect()->route('admin.products.index')->with('success', 'Prix ajouté avec succès.');
    }
    
    /**
     * Affiche un prix spécifique.
     */

    
    
    /**
     * Affiche le formulaire pour modifier un admin.prix.
     */
    public function edit(Product $id)
    {
    $server = ServerOrder::where("categorie",$id->name)->get();
    $extensions = ExtensionManager::getExtensions();
            $categories = Categories::all();

    $fields = json_decode($id->extension_fields, true);


        return view('admin.products.edit', compact('id','server','extensions','fields','categories'));
    }
    /**
     * Met à jour un prix existant.
     */
    public function update(Request $request, Product $id)
    {

        $product = Product::findOrFail($id->id);

        $validatedData = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable', // Ajout de la validation pour l'image
            'maxbyuser' => 'required|integer',
            'stock' => 'required|integer',
            'config' => 'required|array',
        'price' => 'required|integer',
        'info' => 'required|array',
    
    ]);
        foreach ($request->input('config') as $index => $value) {
            $customFields['config'][$index] = $value;
        }
    
      
        foreach ($request->input('info') as $index => $value) {
            $customFields['info'][$index] = $value;
        }
        $validatedData['extension'] = $request->input('extension');

        $validatedData['extension_fields'] = json_encode($customFields);
        $product->update($validatedData);
        
              

        return redirect()->route('admin.products.index')->with('success', 'category mis à jour avec succès.');
    }
    
    
    /**
     * Supprime un admin.prix.
     */
    public function destroy(Product $id)
    {
        $id->delete();
    
        return redirect()->route('admin.categorie.index')->with('success', 'Prix supprimé avec succès.');
    }
}
