<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query(); // Remplace User par le modèle correspondant

        // Appliquer un filtre de recherche
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%') // Recherche sur le nom
                ->orWhere('email', 'like', '%' . $request->search . '%'); // Ou sur l'email
        }

        // Récupérer les utilisateurs avec pagination
        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau admin.prix.
     */


    /**
     * Enregistre un nouveau admin.prix.
     */


    /**
     * Affiche un prix spécifique.
     */
    public function show(User $id)
    {
        return view('admin.users.show', compact('id'));
    }

    /**
     * Affiche le formulaire pour modifier un admin.prix.
     */
    public function edit(User $id)
    {
        $user = $id;
        return view('admin.users.edit', compact('user'));
    }

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
            // Redirection après mise à jour
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Gestion des erreurs de validation
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Gestion des autres erreurs
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de l\'utilisateur.')->withInput();
        }
    }


    /**
     * Supprime un admin.prix.
     */
    public function destroy(User $prix)
    {
        $prix->delete();

        return redirect()->route('admin.users.index')->with('success', 'Prix supprimé avec succès.');
    }
}
