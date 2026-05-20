<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CountHttpRequests
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Incrémentation atomique dans le cache
        Cache::increment('reqquet_count');

        // Toutes les 100 requêtes -> sync DB
        $count = Cache::get('reqquet_count', 0);

        if ($count % 100 === 0) {

            DB::table('settings')->updateOrInsert(
                ['name' => 'reqquet'],
                ['settings' => (string) $count]
            );
        }

        return $next($request);
    }
}