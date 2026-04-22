<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Trensaction;

use App\Models\Credit;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $credit = $request->credit;
    $user = Auth::user();

    if (!$user) {
        return redirect()->back()->with('error', 'Utilisateur non authentifié.');
    }

    if (!$credit || $credit <= 0) {
        return redirect()->back()->with('error', 'Montant invalide pour l\'achat de crédits.');
    }

    // Créer une commande de crédit
    $order = Credit::create([
        'users_id' => $user->id,
        'paypal_order_id' => null,
        'amount' => $credit,
    ]);

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    // Créer une commande PayPal
    $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "amount" => [
                    "currency_code" => "EUR",
                    "value" => $credit,
                ],
            ],
        ],
        "application_context" => [
            "return_url" => route('credit.paypal.success'),
            "cancel_url" => route('credit.paypal.cancel'),
        ],
    ]);

    if (isset($response['id'])) {
        // Mettre à jour l'ID de commande PayPal dans la commande
        $order->update(['paypal_order_id' => $response['id']]);

        // Rediriger l'utilisateur vers le lien de paiement PayPal
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->to($link['href']);
            }
        }
    }

    return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de la commande.');
}

public function cancel()
{
    // Trouver et supprimer la commande liée à l'ID de PayPal
    $paypalOrderId = request()->query('token');
    $order = Credit::where('paypal_order_id', $paypalOrderId)->first();

    if ($order) {
        $order->delete();
    }

    return redirect()->route('dashboard')->with('info', 'Votre achat a été annulé.');
}
public function success(Request $request)
{
    // Récupérer l'ID de la commande PayPal depuis la requête
    $paypalOrderId = $request->query('token');

    // Trouver la commande dans la table 'credit_buy' par son ID de PayPal
    $order = Credit::where('paypal_order_id', $paypalOrderId)->first();

    if (!$order) {
        return redirect()->route('dashboard')->with('error', 'Commande introuvable.');
    }

    // Confirmer la commande PayPal
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $response = $provider->capturePaymentOrder($paypalOrderId);

    if ($response['status'] === 'COMPLETED') {
        // Ajouter les crédits à l'utilisateur
        $user = Auth::user();
        $user->credit += $order->amount;
        $user->save();
        Trensaction::create([
            "cost" => $order->amount,
            "user_id" => $user->id,
            "product" => "credit",

        ]);
        // Supprimer la commande PayPal pour éviter qu'elle ne soit utilisée à nouveau
        $order->delete();
       

        return redirect()->route('dashboard')->with('success', 'Crédits ajoutés avec succès.');
    }

    return redirect()->route('dashboard')->with('error', 'Une erreur est survenue lors de la confirmation de la commande.');
}

  
}
