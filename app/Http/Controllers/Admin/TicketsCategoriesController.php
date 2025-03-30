<?php


namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.tickets.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.tickets.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'priority' => 'required|in:low,medium,high',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.tickets.categorie.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.tickets.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'priority' => 'required|in:low,medium,high',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('admin.tickets.categorie.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.tickets.categorie.index');
    }
}
