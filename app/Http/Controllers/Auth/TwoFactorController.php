<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
  

    public function enable(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_secret = encrypt($request->secret);
        $user->two_factor_recovery_codes = encrypt($request->recovery_codes);
        $user->two_factor_enabled = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', '2FA activée avec succès.');
    }

    public function disable()
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_enabled = false;
        $user->save();

        return redirect()->route('dashboard')->with('success', '2FA désactivée.');
    }
    public function show()
{
    return view('auth.verify-2fa'); // Vue avec un input pour entrer le code

}
public function verify(Request $request)
{
    $user = Auth::user();
    $google2fa = new Google2FA();

    $isValid = $google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code);

    if ($isValid) {
        session(['2fa_passed' => true]);
        return redirect()->route('dashboard');
    }

    return back()->with(['error' => 'Code invalide.']);
    }
}
