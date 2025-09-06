<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
public function index()
{
    $url = "";
    $news = News::all();

    // Récupérer les 4 catégories avec leurs produits (eager loading)
    $categories = Categories::with('products')->take(4)->get();

    // Pour chaque catégorie, on calcule le prix minimal parmi ses produits
    foreach ($categories as $categorie) {
        // On récupère le prix minimal des produits liés à cette catégorie
        $categorie->min_price = $categorie->products->min('price') ?? 0;
    }

    return view('welcome', compact('url', 'news', 'categories'));
}

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('client.news.show', compact('news'));
    }

}
