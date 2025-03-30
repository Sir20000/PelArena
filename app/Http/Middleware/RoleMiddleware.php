<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $route = $request->route()->getName();

        if ($user && $user->hasAccess($route)) {
            return $next($request);
        }
        elseif ($user->role->name == 'admin') {
            return $next($request);
        };

        abort(403, 'Unauthorized');
    }
}