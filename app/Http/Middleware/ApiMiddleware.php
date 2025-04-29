<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKeyModel;   
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        $user = Auth::user();

           // Récupérer le token d'API depuis l'en-tête de la requête
           if ($user) {
           if ($user->role->name == 'admin') {
            return $next($request);
        }
    }
           $token = $request->header('Authorization');

           if (!$token) {
               return response()->json(['error' => 'Token manquant'], 400);
           }
   
           // Supprimer le préfixe 'Bearer ' du token, s'il est présent
           if (substr($token, 0, 7) === 'Bearer ') {
               $token = substr($token, 7);
           }
   
           // Vérifier si le token existe dans la base de données
           $apiKey = ApiKeyModel::all()->first(function ($item) use ($token) {
            // Décryptage du token stocké
            $decryptedToken = Crypt::decrypt($item->token);
            return $decryptedToken === $token;
        });
   
           if (!$apiKey) {
               return response()->json(['error' => 'Token invalide'. Crypt::encrypt($token)], 401);
           }
   
           // Continuer le traitement de la requête si le token est valide
           return $next($request);
    }
}
