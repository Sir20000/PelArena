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

if (!$user) {
    abort(403, 'Unauthorized');
}
if (($user->role && $user->role->name === 'admin') || $user->hasAccess($route)) {
    return $next($request);
}
     

        abort(403, 'Unauthorized');
    }
}