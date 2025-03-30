<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
   // Afficher toutes les news
   public function index()
   {
$url = settings("PTERODACTYL_API_URL");
$news = News::all();
       return view('news', compact('url', 'news'));
   }

   // Afficher une news spécifique
   public function show($id)
   {
       $news = News::findOrFail($id);
       return view('client.news.show', compact('news'));
   }

   // Afficher le formulaire de création de news (admin)
  }
