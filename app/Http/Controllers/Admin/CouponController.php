<?php
namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CouponController extends Controller
{
    /**
     * Afficher la liste des coupons.
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Afficher le formulaire pour créer un nouveau coupon.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Stocker un nouveau coupon dans la base de données.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'string|max:255',
        'reduction' => 'required|numeric|min:0',
        'one_for_user' => 'required|boolean',
        'max_usage' => 'required|integer',
    ]);

    // Vérifier si le champ name est vide
   

    Coupon::create($request->all());

    return redirect()->route('admin.coupons.index')->with('success', 'Coupon créé avec succès.');
}


    /**
     * Afficher le formulaire pour modifier un coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Mettre à jour un coupon existant dans la base de données.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'reduction' => 'required|numeric|min:0',
            'one_for_user' => 'required|boolean',

        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon mis à jour avec succès.');
    }

    /**
     * Supprimer un coupon.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon supprimé avec succès.');
    }
}
