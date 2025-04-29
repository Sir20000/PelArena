<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Prix;

class NewsController extends Controller
{
    public function index()
    {
        $url = settings("PTERODACTYL_API_URL");
        $news = News::all();

// Récupère tous les prix liés aux catégories sélectionnées
$categories = Categories::with('prix')->take(4)->get(); // Eager loading des prix

return view('welcome', compact('url', 'news', 'categories',));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('client.news.show', compact('news'));
    }

}
