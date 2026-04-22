<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use PragmaRX\Google2FAQRCode\Google2FA;

class ProfileController extends Controller
{
     /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {        $user = Auth::user();

        $google2fa = new Google2FA();

        // Génère une nouvelle clé secrète pour l'utilisateur
        $secret = $google2fa->generateSecretKey();

        // Génération de l'URL du QR Code pour Google Authenticator
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            env('APP_NAME'),  // Remplace par le nom de ton app
            $user->email,
            $secret
        );
        return view('profile.edit', [
            'user' => $request->user(),
            'secret'=>$secret, 
            'qrCodeUrl'=>$qrCodeUrl,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
