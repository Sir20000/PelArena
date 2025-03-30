<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Controllers\Utils\PterodactylController;
use Illuminate\Support\Facades\Log;
use App\Models\Prix;


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
        $nodes = PterodactylController::getNodes();

        return view('admin.categorie.create', compact('nodes'));
    }
    
    /**
     * Enregistre un nouveau admin.prix.
     */
    public function store(Request $request)
    {
        log::debug("s");
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable', // Ajout de la validation pour l'image
            'egg_id' => 'required|integer',
            'nests' => 'required|integer',
            'maxram' => 'required|integer',
            'maxcpu' => 'required|integer',
            'maxstorage' => 'required|integer',
            'maxdb' => 'required|integer',
            'maxbackups' => 'required|integer',
            'maxallocations' => 'required|integer',
            'maxbyuser' => 'required|integer',
            'stock' => 'required|integer',
        ]);
        log::debug("a");
        $category = Categories::create($validatedData);
        log::debug("b");
        $priceData = $request->validate([
            'ram' => 'required|numeric|min:0',
            'cpu' => 'required|numeric|min:0',
            'storage' => 'required|numeric|min:0',
            'db' => 'required|numeric|min:0',
            'backups' => 'required|numeric|min:0',
            'allocations' => 'required|numeric|min:0',
         ]);
        log::debug("d");
        $priceData['categories_id'] = $category->id;
        log::debug("sb");
        Prix::create($priceData);
        log::debug("saa");
        return redirect()->route('admin.categorie.index')->with('success', 'Prix ajouté avec succès.');
    }
    
    /**
     * Affiche un prix spécifique.
     */
    public function show(Categories $id)
    {
        $category = $id;
        $selectedNodes = json_decode($category->nodes, true); // Décoder les nodes enregistrés
    
        return view('admin.categorie.show', compact('category', 'selectedNodes'));
    }
    
    
    /**
     * Affiche le formulaire pour modifier un admin.prix.
     */
    public function edit(Categories $id)
    {
        $nodes = PterodactylController::getNodes(); // Récupérer la liste des nodes
        $category = $id;
        $selectedNodes = json_decode($category->nodes, true); // Décoder les nodes enregistrés
    
        return view('admin.categorie.edit', compact('category', 'nodes', 'selectedNodes'));
    }
    /**
     * Met à jour un prix existant.
     */
    public function update(Request $request, Categories $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable',
            'egg_id' => 'required|integer|max:5',
            'nests' => 'required|integer|max:5',
           'maxram' => 'required|integer',
           'maxcpu' => 'required|integer',
           'maxstorage' => 'required|integer',
           'maxdb' => 'required|integer',
           'maxbackups' => 'required|integer',
           'maxallocations' => 'required|integer',
           'maxbyuser' => 'required|integer',
           'stock' => 'required|integer',

        ]);
    
        $id->update($request->all());
        
        
    
        return redirect()->route('admin.categorie.index')->with('success', 'Prix mis à jour avec succès.');
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

