<?php

namespace App\Http\Controllers\Clients;

use App\Models\ServerOrder;
use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\Product;

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

    public function createOrder(Request $request, $product)
    {
        $product = Product::all()->where('id', $product)->first();
        $categorie = Categories::all()->where('id', $product->categorie)->first();
        
        if (!$product) {
            abort(404);
        }
        $request->validate([
            'value' => 'required|array'

        ]);

        $extension_fields = json_decode($product->extension_fields, true);
        $prix = $product->price;
       

        if ($product->stock == 0) {

            return redirect()->route('client.servers.index');
        }
        $taux = settings("tva");
        $total_tva = $prix * $taux / 100;
        $total = $prix + $total_tva;
        $total = round($total, 2);
        $order = ServerOrder::create([
            'server_name' => $request->server_name,

            'cost' => $total,

            'user_id' => Auth::id(),
            'status' => 'pending',
            'extension_fields' => $request->value,
            'categorie' => $categorie->name,
            'product_id' => $product->id,


        ]);
        $provider = ExtensionManager::load($product->extension);

        if ($provider) {
            $serverData = $order->toArray();
            $serverData["email"] = Auth::user()->email;
            $serverData["info"] = $extension_fields['info'];
            $serverData["categorie"] = $categorie;


            $create = $provider->createServer($serverData);
            $extension = $order->extension_fields ?? [];
            $extension['info'] = $create['info'];
            $order->extension_fields = $extension;
            $order->save();
        } else {
        }







        if ($create) {
            $provider->suspendServer($create["info"]);

            if ($product->stock !== -1) {
                $product->stock = $product->stock - 1;
                $product->save();
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
        $products = Product::where("categorie", $categorie->id)->get();
        return view('client.categories.product', compact('categorie', 'products'));
    }
    public function product(Request $request, $categorie,Product $id)
    {
    $product =$id;

        $extension_fields = json_decode($product->extension_fields, true);
        $prix = $product->price;
        $maxValues = $extension_fields['config'];
        $server = ServerOrder::where('product_id', $product->name)->where('user_id', auth()->id())->count();
        $provider = ExtensionManager::load($product->extension);

        $fields = $provider->getFieldsNeeded($product);

        if ($product) {
            if ($product->maxbyuser == 0 || $server <= $product->maxbyuser) {
                if ($product->stock == 0) {
                    return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez pas commandé dans cette catégorie. Cette catégorie est hors stock');
                }
                $tva = settings("tva");
                return view('client.servers.orders.index', compact('product','categorie', 'prix', 'tva', "fields", "maxValues"));
            } else {
                return  redirect()->route('client.servers.orders')->with('error', 'Vous ne pouvez plus commandé dans cette catégorie.');
            }
        } else {
            return redirect()->route('client.servers.orders')->with('error', 'La catégorie n\'existe pas.');
        }
    }
}
