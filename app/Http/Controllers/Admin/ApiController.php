<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKeyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apikeys = ApiKeyModel::where("user_id", $request->user()->id)->where("key_type","admin")->get();
        return view("admin.api.index", compact("apikeys"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return str_starts_with($route->getName(), 'api');
        });
        return view("admin.api.create", compact("routes"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'memo' => 'required|string|max:255',
                'permissions' => 'required|array', // Valide que "permissions" est un tableau
                'permissions.*' => 'required|string|in:none,read,read/write', // Valide que chaque permission est une valeur correcte
            ]);
        $apiKey = new ApiKeyModel();
        $apiKey->user_id = $request->user()->id;
        $apiKey->memo = $request->input('memo');
        $plainToken = "Plan_ADMIN_" . Str::random(60);
        $encryptedToken = encrypt($plainToken);
        $apiKey->token = $encryptedToken; 
        $apiKey->key_type = 'admin';

        $apiKey->permision = json_encode($request->input('permissions'));
        $apiKey->save();

        return redirect()->route('admin.api.index')->with('success', 'API Key created successfully.');
        return redirect()->route('admin.api.index')->with('success', 'API Key created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An unexpected error occurred while creating the API Key.'.$e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apiKey = ApiKeyModel::where('user_id', auth()->id())->findOrFail($id);
        $apiKey->delete();

        return redirect()->route('admin.api.index')->with('success', 'API Key deleted successfully.');
    }
}
