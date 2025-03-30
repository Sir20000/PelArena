<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

use App\Models\Coupon;
use App\Models\ServerOrder;

class CouponController extends Controller
{
    public function coupon(Request $request, ServerOrder $order)
{
    $couponCode = $request->input('coupon');
    $user = $request->user(); 
    $productId = $order->id; 

    $coupon = Coupon::where('name', $couponCode)->first();

    if (!$coupon) {
        return back()->with('error', 'Invalid coupon!');
    }
    if ($coupon->one_for_user) {
        $alreadyUsedByUser = $coupon->usages()
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyUsedByUser) {
            return back()->with('error', 'Ce coupon est utilisable une seule fois par utilisateur!');
        }
    }
    $alreadyUsed = $coupon->usages()
        ->where('user_id', $user->id)
        ->where('server_orders_id', $order->id)
        ->exists();

    if ($alreadyUsed) {
        return back()->with('error', 'Vous avez déjà utilisé ce coupon pour ce produit!');
    }
    if ($coupon->expire_time && now()->greaterThan($coupon->expire_time)) {
        return back()->with('error', 'Ce coupon a expiré!');
    }
    if ($coupon->max_usage === 0) {
        return back()->with('error', 'Ce coupon a expiré!');
    }
    $coupon->max_usage = $coupon->max_usage - 1;
    $coupon->save();
    $reducedCost = round($order->cost * (1 - $coupon->reduction / 100), 2);
    $order->update(['cost' => $reducedCost]);
    $coupon->usages()->create([
        'user_id' => $user->id,
        'server_orders_id' => $order->id,
    ]);

    return back()->with('success', 'Coupon appliqué avec succès!');
}

}
