<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Ensure2FAEnabled
{
    public function handle($request, Closure $next)
    {
      
        if (Auth::check() && Auth::user()->two_factor_enabled && !session('2fa_passed') && Auth::user()->two_factor_secret) {
            return redirect()->route('auth.verify-2fa');
        }

        return $next($request);
    }
}