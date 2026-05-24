<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CheckUserDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle($request, Closure $next)
{           
    if (Auth::check()) {
        // Use the model method instead of accessing a property directly
        if (!Auth::user()->isEnabled()) {
            abort(403, 'Compte desactivé'); // Accès refusé
        }
    }

    return $next($request);
}
}
