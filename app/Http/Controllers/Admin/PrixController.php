<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prix;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class PrixController extends Controller
{
    public function index()
{
    $prix = Prix::with('categorie')->get();
    return view('admin.prix.index', compact('prix'));
}

/**
 * Affiche le formulaire pour créer un nouveau admin.prix.
 */
public function create()
{
    $categories = Categories::all();
    return view('admin.prix.create', compact('categories'));
}

/**
 * Enregistre un nouveau admin.prix.
 */
public function store(Request $request)
{
    $request->validate([
        'ram' => 'required|numeric|min:0',
        'cpu' => 'required|numeric|min:0',
        'storage' => 'required|numeric|min:0',
        'db' => 'required|numeric|min:0',
        'backups' => 'required|numeric|min:0',
        'allocations' => 'required|numeric|min:0',
        'categories_id' => 'required|exists:categories,id|unique:prix,categories_id',
    ]);

    Prix::create($request->all());

    return redirect()->route('admin.prix.index')->with('success', 'Prix ajouté avec succès.');
}

/**
 * Affiche un prix spécifique.
 */
public function show(Prix $id)
{
    $prix = $id;
    return view('admin.prix.show', compact('prix'));
}

/**
 * Affiche le formulaire pour modifier un admin.prix.
 */
public function edit(Prix $id)
{
    $prix = $id;
    $categories = Categories::all();
    return view('admin.prix.edit', compact('prix', 'categories'));
}

/**
 * Met à jour un prix existant.
 */
public function update(Request $request, Prix $id)
{

    try {

        $request->validate([
            'ram' => 'required|numeric|min:0',
            'cpu' => 'required|numeric|min:0',
            'storage' => 'required|numeric|min:0',
            'db' => 'required|numeric|min:0',
            'backups' => 'required|numeric|min:0',
            'allocations' => 'required|numeric|min:0',
            'categories_id' => 'required|exists:categories,id|unique:prix,categories_id,' . $id->id,
        ]);
        

        $id->update($request->all());

        return redirect()->route('admin.prix.index')->with('success', 'Prix mis à jour avec succès.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour.')->withInput();
    }
}


/**
 * Supprime un admin.prix.
 */
public function destroy(Prix $prix)
{
    $prix->delete();

    return redirect()->route('admin.prix.index')->with('success', 'Prix supprimé avec succès.');
}
}
