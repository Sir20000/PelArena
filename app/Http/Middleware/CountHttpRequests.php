<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CountHttpRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       // Récupération et conversion en entier
// Récupérer la valeur de 'reqquet'
$reqquetValue = settings("reqquet");

// Vérification de la valeur retournée avant conversion

// Conversion en entier, si la valeur existe
$a = (int) $reqquetValue;

// Incrémentation
$a++;

// Reconversion en chaîne de caractères
$a = (string) $a;

// Mise à jour dans la base de données
DB::table('settings')->updateOrInsert(['name' => 'reqquet'], ['settings' => (string)$a]);



        
        
        return $next($request);
    }
}
