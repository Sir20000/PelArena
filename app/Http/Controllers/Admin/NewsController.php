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
   }}
