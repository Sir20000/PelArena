<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $key = env('PTERODACTYL_API_KEY');
        $url = env('PTERODACTYL_API_URL');
      
        if (empty($key) || empty($url)) {
            return response()->json([
                'error' => 'Configuration manquante. Vérifiez les variables d\'environnement.',
            ], 400);
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'affiliate_code' => 'nullable|string|exists:users,affiliate_code',

        ]);
        $referredBy = [];
        if ($request->filled('affiliate_code')) {
            $referredBy = User::where('affiliate_code', $request->affiliate_code)->first();
            $referredBy->credit += settings("affiliationrecived");
            $referredBy->save();
            $creditget = settings("affiliationget");
        }else{
            
            $creditget = 0;

        }
        // Envoi de la requête à l'API Pterodactyl pour créer l'utilisateur
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',

        ])->post(env('PTERODACTYL_API_URL') . '/api/application/users', [
            'username' => $request->name,
            'email' => $request->email,
            'last_name' => $request->name,
            'first_name' => '#0000',
            'password' => $request->password,
            // Ajoutez d'autres informations nécessaires ici
        ]);


        // Vérifie si la création de l'utilisateur a réussi (code HTTP 201)
        if ($response->status() === 201) {
            $userData = $response->json();
            // Récupérer l'ID de l'utilisateur créé dans Pterodactyl
            // Créer un utilisateur dans la base de données avec l'ID de Pterodactyl
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'pterodactyl_user_id' => $userData['attributes']['id'],  // Enregistrez l'ID Pterodactyl
                'referred_by' => isset($referredBy->id) ? $referredBy->id : null,
                'credit' => $creditget,
            ]);

            // Déclenche l'événement de l'utilisateur enregistré
            event(new Registered($user));

            // Connecte l'utilisateur
            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        }

        // Si la requête échoue, redirigez avec une erreur
        return redirect()->back()->withErrors(['error' => 'La création de l\'utilisateur a échoué.']);
    }
}
