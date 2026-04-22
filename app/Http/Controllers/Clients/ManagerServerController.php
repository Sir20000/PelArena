<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;

use App\Models\Categories;
use App\Models\Product;

use App\Models\ServerOrder;
use App\Http\Controllers\Utils\PterodactylController;
use App\Extensions\ExtensionManager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ManagerServerController extends Controller
{
//all people can acces

    public function index(ServerOrder $server)
    {
        CheckProduct($server->id);

        $categorie = Categories::all()->where("name", $server->categorie)->first();
                $product = Product::all()->where("id", $server->product_id)->first();

        log::debug($product);
        if(!$categorie){
            abort(404);
                    }
                            $provider = ExtensionManager::load($product->extension);

return $provider->managerserver($server);
        }
    }

