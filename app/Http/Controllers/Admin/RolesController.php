<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return str_starts_with($route->getName(), 'admin');
        });
        return view('admin.roles.create' , compact("routes"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'required|array',
        ]);

        Role::create($request->only('name', 'permissions'));

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }}
