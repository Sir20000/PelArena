<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\ServerOrder;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() 
    {
        $credit = User::where ('id',Auth::user()->id)->first()->credit;
        $serverCount = ServerOrder::where('user_id',Auth::id())->count();
        $totalCost = ServerOrder::where('user_id', Auth::id())->where('status', '!=', 'cancelled')->sum('cost');
        $ticket = Ticket::where('user_id',Auth::id())->count();
        $serverCountPending = ServerOrder::where('user_id',Auth::id())->where('status', 'pending')
        ->count();
        $affiliate = User::where('referred_by',Auth::id())->count();

        

        return view('client.dashboard',compact("serverCount","totalCost","serverCountPending","credit","ticket","affiliate"));

    }
}
