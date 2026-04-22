<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all(); 

        // Retourne les utilisateurs en JSON
        return response()->json(['data' => $users]);
    }

    public function show(User $id)
    {
        // Retourne l'utilisateur demandé en JSON
        return response()->json(['data' => $id]);
    }

    /**
     * Affiche le formulaire pour modifier un admin.prix.
     */
    public function update(Request $request, User $id)
    {
        try {
            $request->merge(['enable' => $request->has('enable')]);

            // Validation des champs du formulaire
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'pterodactyl_user_id' => 'required|integer|min:0',
                'credit' => 'required|integer|min:0',
                'affiliate_code' => 'nullable|string|max:255',
                'role_id' => 'required|integer|min:0',
                'enable' => 'required|boolean',
                'two_factor_enabled' => 'required|boolean',
            ]);

            // Mise à jour des données utilisateur
            $data = $request->only([
                'name',
                'email',
                'pterodactyl_user_id',
                'credit',
                'affiliate_code',
                'role_id',
                'enable',
                'two_factor_enabled'
            ]);

            // Vérifier si un mot de passe a été fourni et le hacher
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Mise à jour des données utilisateur
            $id->update($data);

            // Retourne un message de succès en JSON
            return response()->json(['message' => 'Utilisateur mis à jour avec succès.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Gestion des erreurs de validation
            return response()->json(['errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de l\'utilisateur.'], 500);
        }
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $id)
    {
        $id->delete();

        // Retourne un message de succès en JSON
        return response()->json(['message' => 'Utilisateur supprimé avec succès.'], 200);
    }
}
