<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\ServerOrder;
use App\Models\Categories;
use App\Models\Prix;
use App\Models\Trensaction;

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



            $order->update(['status' => 'active', 'renouvelle' => Carbon::now()->addMonth(1)]);
            $serverId = $order->server_id;
            $suspendResponse = Http::withHeaders(headers: [
                'Authorization' => 'Bearer ' . env(key: 'PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(url: env(key: 'PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/unsuspend", data: []);
            $categorie = $order->categorie;
            $categorieid = Categories::all()->where('name', $categorie)->first();
            $prix = Prix::all()->where('categories_id', $categorieid)->first();
            $prix_ram = $order->ram * $prix->ram;
            $prix_cpu = $order->cpu * $prix->cpu;
            $prix_disk = $order->disk * $prix->disk;
            $prix_db = $order->db * $prix->db;
            $prix_allocations = $order->allocations * $prix->allocations;
            $prix_backups = $order->backups * $prix->backups;
            $total = $prix_ram + $prix_cpu + $prix_disk + $prix_db +
                $prix_allocations + $prix_backups;
                $taux =settings("tva");
                $total = $total * (1 +$taux / 100);
                
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
            $serverId = $order->server_id;
            $suspendResponse = Http::withHeaders(headers: [
                'Authorization' => 'Bearer ' . env(key: 'PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(url: env(key: 'PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/unsuspend", data: []);
            Trensaction::create([
                "cost" => $order->cost,
                "user_id" => auth()->id(),
                "product" => "serveur",
                "server_order_id" => $order->id,
            ]);
            $categorie = $order->categorie;
            $categorieid = Categories::all()->where('name', $categorie)->first();

            $prix = Prix::all()->where('categories_id', $categorieid->id)->first();

            $prix_ram = $order->ram * $prix->ram;
            $prix_cpu = $order->cpu * $prix->cpu;
            $prix_disk = $order->disk * $prix->disk;
            $prix_db = $order->db * $prix->db;
            $prix_allocations = $order->allocations * $prix->allocations;

            $prix_backups = $order->backups * $prix->backups;
            $total = $prix_ram + $prix_cpu + $prix_disk + $prix_db +
                $prix_allocations + $prix_backups;

                $taux =settings("tva");
                $total = $total * (1 +$taux / 100);
                
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
            $serverId = $order->server_id;
            $suspendResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PTERODACTYL_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/unsuspend", []);
           $categorie = $order->categorie;
            $categorieid = Categories::all()->where('name', $categorie)->first();

            $prix = Prix::all()->where('categories_id', $categorieid->id)->first();

            $prix_ram = $order->ram * $prix->ram;
            $prix_cpu = $order->cpu * $prix->cpu;
            $prix_disk = $order->disk * $prix->disk;
            $prix_db = $order->db * $prix->db;
            $prix_allocations = $order->allocations * $prix->allocations;

            $prix_backups = $order->backups * $prix->backups;
            $total = $prix_ram + $prix_cpu + $prix_disk + $prix_db +
                $prix_allocations + $prix_backups;

                $taux =settings("tva");
                $total = $total * (1 +$taux / 100);
                
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

        $suspendResponse = Http::withHeaders(headers: [
            'Authorization' => 'Bearer ' . env(key: 'PTERODACTYL_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post(url: env(key: 'PTERODACTYL_API_URL') . "/api/application/servers/{$serverId}/suspend", data: []);
        return redirect()->route(route: 'client.servers.index')->with(key: 'error', value: 'Le paiement a été annulé.');
    }
}
