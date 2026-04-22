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
use App\Extensions\ExtensionManager;
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
    

     
        // Vérifie si la création de l'utilisateur a réussi (code HTTP 201)
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'referred_by' => isset($referredBy->id) ? $referredBy->id : null,
                'credit' => $creditget,
            ]);
            $userData = $user->toArray();
            $userData['password'] = $request->password; // Ajoute le mot de passe manuellement

            ExtensionManager::executeOnAllExtensions(function ($instance, $key) use ($userData) {
                if (method_exists($instance, 'createUser')) {
                    $instance->createUser($userData);
                    \Log::info("Méthode createUser exécutée pour l'extension {$key}");
                }
            });
            // Déclenche l'événement de l'utilisateur enregistré
            event(new Registered($user));

            // Connecte l'utilisateur
            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        

        // Si la requête échoue, redirigez avec une erreur
    }
}
