<?php

namespace App\Http\Controllers\Clients;

use App\Models\ServerOrder;
use Illuminate\Http\Request;

use App\Models\Categories;

use App\Http\Controllers\Controller;

use App\Extensions\ExtensionManager;
use Illuminate\Support\Facades\Auth;

class ServersController extends Controller
{

    public function index(Request $request)
    {
        $query = ServerOrder::where('user_id', Auth::id())
            ->orderBy('status', 'asc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('server_name', 'like', '%' . $request->search . '%')
                    ->orWhere('categorie', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->paginate(10);

        return view('client.servers.index', compact('orders'));
    }

    public function categorie()
    {
        $categories = Categories::all();
        return view('client.categories.index', compact('categories'));
    }

    public function createOrder(Request $request, $categorie)
    {
        $categorie = Categories::all()->where('id', $categorie)->first();
        if (!$categorie) {
            abort(404);
        }
        $request->validate([
            'value' => 'required|array'

        ]);
        $totalPrice = 0;

        $extension_fields = json_decode($categorie->extension_fields,true);
        $prix = $extension_fields['prix'];
        $maxValues = $extension_fields['max'];
        foreach ($request->input('value') as $key => $value) {
            if (isset($maxValues[$key]) && $value > $maxValues[$key]) {
                return back()->with([
                    'error' => "The value for {$key} has exceeded the maximum limit of {$maxValues[$key]}."
                ]);
            }
            if (isset($prix[$key])) {
                $totalPrice += $prix[$key] * $value;
            }
        }

        if ($categorie->stock == 0) {

            return redirect()->route('client.servers.index');
        }
        $taux = settings("tva");
        $total_tva = $totalPrice * $taux / 100;
        $total = $totalPrice + $total_tva;
        $total = round($total, 2);
        $order = ServerOrder::create([
            'server_name' => $request->server_name,

            'cost' => $total,

            'user_id' => Auth::id(),
            'status' => 'pending',
            'extension_fields' => $request->value,
            'categorie' => $categorie->name,


        ]);
        $provider = ExtensionManager::load($categorie->extension);

        if($provider){
            $serverData = $order->toArray();
            $serverData["email"] =Auth::user()->email;
            $serverData["info"] = $extension_fields['info'];
            $serverData["categorie"] = $categorie;


            $create = $provider->createServer($serverData);
            $extension = $order->extension_fields ?? [];
            $extension['info'] = $create['info'];
            $order->extension_fields = $extension;
            $order->save();
                }else  {

        }
   
        

      

     

        if ($create) {
            $provider->suspendServer($create["info"]);
            
            if ($categorie->stock !== -1) {
                $categorie->stock = $categorie->stock - 1;
                $categorie->save();
            }
            return redirect()->route('client.servers.index')->with('success', 'Commande de serveur réussie !');
        }

        $order->update(['status' => 'cancelled']);
        return redirect()->route('client.servers.index')->with('error', 'Échec de la commande du serveur.');
    }


    public function orders(Request $request, $a)
    {
        $categorie = Categories::where('name', $a)->first();
        if (!$categorie) {
            abort(404);
        }
        $extension_fields = json_decode($categorie->extension_fields,true);
        $prix = $extension_fields['prix'];
        $maxValues = $extension_fields['max'];
        $server = ServerOrder::where('categorie', $categorie->name)->where('user_id', auth()->id())->count();
        $provider = ExtensionManager::load('pterodactyl');

        $fields = $provider->getFieldsNeeded();
        
        if ($categorie) {
            if ($categorie->maxbyuser == 0 || $server <= $categorie->maxbyuser) {
                if ($categorie->stock == 0) {
                    return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez pas commandé dans cette catégorie. Cette catégorie est hors stock');
                }
                $tva = settings("tva");
                return view('client.servers.orders.index', compact('categorie', 'prix', 'tva',"fields","maxValues"));
            } else {
                return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez plus commandé dans cette catégorie.');
            }
        } else {
            return redirect()->route('client.servers.orders')->with('error', 'La catégorie n\'existe pas.');
        }
    }
   
 
}
