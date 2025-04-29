<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
  

   // Afficher le formulaire de création de news (admin)
   public function create()
   {
       return view('admin.news.create');
   }

   // Enregistrer une nouvelle news
   public function store(Request $request)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'required|string',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

       // Gestion de l'image téléchargée
       $imagePath = $request->file('image')->store('news_images', 'public');

       // Créer la news
       News::create([
           'title' => $request->title,
           'description' => $request->description,
           'image' => $imagePath,
       ]);

       return redirect()->route('admin.news.index')->with('success', 'News créée avec succès');
   }

   // Afficher toutes les news dans l'admin
   public function index()
   {
       $news = News::all();
       return view('admin.news.index', compact('news'));
   }
   public function update(Request $request, News $id)
   {
   
       try {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('news_images', 'public');
        } else {
            $imagePath = $existingNews->image ?? null; // Utiliser l'image existante si aucune nouvelle image n'est envoyée
        }
           
           
   
           $id->update($request->all());
   
           return redirect()->route('admin.news.index')->with('success', 'Prix mis à jour avec succès.');
       } catch (\Illuminate\Validation\ValidationException $e) {
           return redirect()->back()->withErrors($e->errors())->withInput();
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour.' .$e )->withInput();
       }
   }
   
   
   /**
    * Supprime un admin.news.
    */
   public function destroy( News $new)
   {
       $new->delete();
   
       return redirect()->route('admin.news.index')->with('success', 'New supprimé avec succès.');
   }
   public function edit( News $id) {
    $new =$id;

    return view('admin.news.edit', compact('new'));
   }
   }
