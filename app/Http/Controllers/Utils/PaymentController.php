<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\ServerOrder;
use App\Models\Categories;
use App\Models\Prix;
use App\Models\Trensaction;
use App\Extensions\ExtensionManager;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class PaymentController extends Controller
{
    public function index($id)
    {
        $creditornot = 012;
        $order = ServerOrder::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $user = auth()->user();

        if ($order->cost == 0) {
            $categorie = $order->categorie;
            $product = $order->product_id;

            $categorieid = Categories::all()->where('name', $categorie)->first();
            $product = Product::all()->where('id', $product)->first();


            $order->update(['status' => 'active', 'renouvelle' => Carbon::now()->addMonth(1)]);
            $serverId = $order->server_id;
   $provider = ExtensionManager::load($product->extension);

            if($provider){
            $info = $order->extension_fields;
               $corder = $provider->unsuspendServer($info["info"]);
            }
           log::debug($corder);
           
   Trensaction::create([
                "cost" => $order->cost,
                "user_id" => auth()->id(),
                "product" => "serveur",
                "server_order_id" => $order->id,
            ]);

        $prix = $product->price;
        $taux = settings("tva");
        $total_tva = $prix * $taux / 100;
        $total = $prix + $total_tva;
        $total = round($total, 2);

            $order->update(['cost' => $total]);

            return redirect()->route(route: 'client.servers.index')->with(key: 'success', value: 'Commande payée avec succès.');
        }
        if ($user->credit <= $order->cost) {

            $creditornot = 0;
        }
        return view('client.paypal.payment', compact('order', 'creditornot'));
    }
    public function pay($id)
    {
        $order = ServerOrder::find(id: $id);

        if (!$order) {
            return redirect()->back()->with(key: 'error', value: 'La commande n\'existe pas.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(credentials: config(key: 'paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder(data: [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $order->cost,
                    ],
                ],
            ],
            "application_context" => [
                "return_url" => route(name: 'paypal.success'),
                "cancel_url" => route(name: 'paypal.cancel'),
            ],
        ]);

        if (isset($response['id'])) {
            $order->update(['paypal_order_id' => $response['id']]);

            return redirect(to: $response['links'][1]['href']);
        }

        return redirect()->back()->with(key: 'error', value: 'Une erreur est survenue.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(credentials: config(key: 'paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder(order_id: $request->query(key: 'token'));

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $order = ServerOrder::where(column: 'paypal_order_id', operator: $response['id'])->first();
            $order->update([
                'status' => 'active',
                'renouvelle' => $order->renouvelle ? Carbon::parse($order->renouvelle)->addMonth(1) : Carbon::now()->addMonth(1),
            ]);

        $productId = $order->product_id;
$product = Product::find($productId);

Log::debug($product);
            Trensaction::create([
                "cost" => $order->cost,
                "user_id" => auth()->id(),
                "product" => "serveur",
                "server_order_id" => $order->id,
            ]);
            $categorie = $order->categorie;
            $totalPrice = $product->price;


       $provider = ExtensionManager::load($product->extension);

            if($provider){
            $info = $order->extension_fields;
               $corder = $provider->unsuspendServer($info["info"]);
            }
           log::debug($corder);
    
            $taux = settings("tva");
            $total_tva = $totalPrice * $taux / 100;
            $total = $totalPrice + $total_tva;
            $total = round($total, 2);
            $order->update(['cost' => $total]);

            return redirect()->route(route: 'client.servers.index')->with(key: 'success', value: 'Commande payée avec succès.');
        }

        return redirect()->route(route: 'client.servers.index')->with(key: 'error', value: 'Le paiement a échoué.');
    }

    public function cancel()
    {
        return redirect()->route(route: 'client.servers.index')->with(key: 'error', value: 'Le paiement a été annulé.');
    }

    public function credit($id)
    {
        $user = auth()->user();
        $order = ServerOrder::find($id);
        if ($user->credit >= $order->cost) {
            $user->credit = $user->credit - $order->cost;
            $user->save();
            $order->update(['status' => 'active', 'renouvelle' => Carbon::now()->addMonth(1)]);
            $categorie = $order->categorie;

            $serverId = $order->server_id;
            $categorieid = Categories::all()->where('name', $categorie)->first();
            $serverId = $order->server_id;
            $provider = ExtensionManager::load($categorieid->extension);

            if($provider){
            $info = $order->extension_fields;
                $provider->suspendServer($info["info"]);
            }
           $categorie = $order->categorie;
            $categorieid = Categories::all()->where('name', $categorie)->first();

            $totalPrice = 0;

            $extension_fields = json_decode($categorieid->extension_fields,true);
            $prix = $extension_fields['prix'];
            $maxValues = $extension_fields['max'];
    
            foreach ($order->extension_fields as $key => $value) {
                if ($key === 'info') {
                    continue;
                }
            
                if (isset($prix[$key])) {
                    $totalPrice += $prix[$key] * $value;
                }
            }
    
            $taux = settings("tva");
            $total_tva = $totalPrice * $taux / 100;
            $total = $totalPrice + $total_tva;
            $total = round($total, 2);

            $order->update(['cost' => $total]);

            return redirect()->route(route: 'client.servers.index')->with('success',  'Commande payée avec succès.');
        }
        return redirect()->route(route: 'client.servers.index')->with('error', 'Crédit inssufisant.');
    }
    public function cancelp($id)
    {
        $order = ServerOrder::find(id: $id);
        $order->update(['status' => 'cancelled']);
        $order->save();
        $serverId = $order->server_id;
        $categorie = $order->categorie;

        $serverId = $order->server_id;
        $categorieid = Categories::all()->where('name', $categorie)->first();
        $serverId = $order->server_id;
        $provider = ExtensionManager::load($categorieid->extension);

        if($provider){
        $info = json_decode($order->extension_fields,true);
            $provider->suspendServer($info["info"]);
        }
        return redirect()->route(route: 'client.servers.index')->with(key: 'error', value: 'Le paiement a été annulé.');
    }
}
