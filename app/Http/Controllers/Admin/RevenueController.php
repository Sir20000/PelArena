<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trensaction;
use Carbon\Carbon;


class RevenueController extends Controller
{
    public function index(Request $request)
{
        $currentMonthRevenue = Trensaction::query()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('cost');

        $revenuesByYear = Trensaction::query()
            ->selectRaw('YEAR(created_at) as year, SUM(cost) as total_revenue')
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();
            $query = Trensaction::query(); // Remplace User par le modèle correspondant

            // Appliquer un filtre de recherche
            if ($request->has('search') && !empty($request->search)) {
                $query->where('name', 'like', '%' . $request->search . '%') // Recherche sur le nom
                      ->orWhere('email', 'like', '%' . $request->search . '%'); // Ou sur l'email
            }
        
            // Récupérer les utilisateurs avec pagination
            $transaction = $query->paginate(20);
        return view('admin.revenue.index', compact('currentMonthRevenue', 'revenuesByYear',"transaction"));
    }
}
