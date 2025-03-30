<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prix;

use App\Http\Controllers\Controller;
use App\Models\CouponUsage;
use App\Models\ServerOrder;
use App\Models\User;
use App\Models\Trensaction;
use App\Models\Ticket;
use App\Models\Credit;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index()
    {
        try {
            // Statistiques globales
            $totalUsers = User::count();
            $totalOrders = ServerOrder::count();
            $totalTransactions = Trensaction::count();
            $totalCredits = User::sum('credit') ?? 0;
            $totalCouponUsage = CouponUsage::count();
            $openTickets = Ticket::where('status', 'open')->count();
            $closedTickets = Ticket::where('status', 'closed')->count();

            $currentMonthRevenue = Trensaction::query()
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('cost');
            $lastMonthRevenue = Trensaction::query()
                ->whereMonth('created_at', Carbon::now()->month - 1)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('cost');
            $lastYearRevenue = Trensaction::query()
                ->whereYear('created_at', Carbon::now()->year - 1)
                ->sum('cost');
            $thisYearRevenue = Trensaction::query()
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('cost');

            // Récupération des statistiques sur les 7 derniers jours
            $dates = [];
            $userStats = [];
            $orderStats = [];
            $transactionStats = [];
            $ticketStats = [];
            $datesYear = [];
            $userStatsYear = [];
            $orderStatsYear = [];
            $transactionStatsYear = [];
            $ticketStatsYearr = [];
            for ($i = 30; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->toDateString();
                $dates[] = $date;

                $userStats[] = User::whereDate('created_at', $date)->count();
                $orderStats[] = ServerOrder::whereDate('created_at', $date)->count();
                $transactionStats[] = Trensaction::whereDate('created_at', $date)->count();
                $ticketStats[] = Ticket::whereDate('created_at', $date)->count();
            }
            for ($i = 12; $i >= 0; $i--) {
                // Obtenir le premier jour du mois en cours moins $i mois
                $dateYear = Carbon::now()->copy()->subMonths($i)->startOfMonth()->toDateString();
                $datesYear[] = $dateYear;

                $userStatsYear[] = User::whereMonth('created_at', '=', Carbon::parse($dateYear)->month)
                    ->whereYear('created_at', '=', Carbon::parse($dateYear)->year)
                    ->count();

                $orderStatsYear[] = ServerOrder::whereMonth('created_at', '=', Carbon::parse($dateYear)->month)
                    ->whereYear('created_at', '=', Carbon::parse($dateYear)->year)
                    ->count();

                $transactionStatsYear[] = Trensaction::whereMonth('created_at', '=', Carbon::parse($dateYear)->month)
                    ->whereYear('created_at', '=', Carbon::parse($dateYear)->year)
                    ->count();

                $ticketStatsYear[] = Ticket::whereMonth('created_at', '=', Carbon::parse($dateYear)->month)
                    ->whereYear('created_at', '=', Carbon::parse($dateYear)->year)
                    ->count();
            }
            $datesEver = [];
            $userStatsEver = [];
            $orderStatsEver = [];
            $transactionStatsEver = [];
            $ticketStatsEver = [];

            // On récupère la date du premier mois avec des données disponibles
            $firstMonth = User::min('created_at'); // Par exemple, la première date d'inscription d'un utilisateur
            $carbonDate = Carbon::parse($firstMonth); // Transforme cette date en instance Carbon

            // Tant que la date courante est avant aujourd'hui, on récupère les statistiques mensuelles
            while ($carbonDate <= Carbon::now()) {
                $dateEver = $carbonDate->startOfMonth()->toDateString(); // Le premier jour du mois
                $datesEver[] = $dateEver;

                $userStatsEver[] = User::whereMonth('created_at', '=', $carbonDate->month)
                    ->whereYear('created_at', '=', $carbonDate->year)
                    ->count();

                $orderStatsEver[] = ServerOrder::whereMonth('created_at', '=', $carbonDate->month)
                    ->whereYear('created_at', '=', $carbonDate->year)
                    ->count();

                $transactionStatsEver[] = Trensaction::whereMonth('created_at', '=', $carbonDate->month)
                    ->whereYear('created_at', '=', $carbonDate->year)
                    ->count();

                $ticketStatsEver[] = Ticket::whereMonth('created_at', '=', $carbonDate->month)
                    ->whereYear('created_at', '=', $carbonDate->year)
                    ->count();

                // Passe au mois suivant
                $carbonDate->addMonth();
            }
            $prixData = Prix::with('categorie') // Charge les catégories associées
                ->get();

                $totalrequete =settings("reqquet");
            return view('admin.statistique.index', compact(
                'totalUsers',
                'totalOrders',
                'totalTransactions',
                'totalCredits',
                'totalCouponUsage',
                'openTickets',
                'closedTickets',
                'dates',
                'userStats',
                'orderStats',
                'transactionStats',
                'ticketStats',
                'datesEver',
                'userStatsEver',
                'orderStatsEver',
                'transactionStatsEver',
                'ticketStatsEver',
                'datesYear',
                'userStatsYear',
                'orderStatsYear',
                'transactionStatsYear',
                'ticketStatsYear',
                'currentMonthRevenue',
                'lastMonthRevenue',
                'lastYearRevenue',
                'thisYearRevenue',
                'prixData',
                'totalrequete'
            ));
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des statistiques : " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du chargement des statistiques.');
        }
    }
}
