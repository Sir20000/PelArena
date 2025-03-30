<?php

namespace App\Http\Controllers\Clients;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\TicketMessage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('category', 'user')
            ->orderByRaw("FIELD(status, 'open') DESC")
            ->orderBy('created_at', 'desc')
            ->where("user_id",Auth::id())
            ->get();

        return view('client.tickets.index', compact('tickets'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('client.tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories_tickets,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        Ticket::create([
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket ouvert avec succès!');
    }

    public function show($ticketId)
    {
        $yourticket = Ticket::with('category', 'user')
            ->orderByRaw("FIELD(status, 'open') DESC")
            ->orderBy('created_at', 'desc')
            ->where("user_id",Auth::id())
            ->where('id', $ticketId)
            ->get();
        if ($yourticket->isEmpty()) {
            abort(404);
            }
        $ticket = Ticket::findOrFail($ticketId);
        $messages = TicketMessage::where('ticket_id', $ticketId)->get();
        return view('client.tickets.show', compact('ticket', 'messages'));
    }

    public function close($id)
    { $yourticket = Ticket::with('category', 'user')
        ->orderByRaw("FIELD(status, 'open') DESC")
        ->orderBy('created_at', 'desc')
        ->where("user_id",Auth::id())
        ->where('id', $id)
        ->get();
    if ($yourticket->isEmpty()) {
        abort(404);
        }
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => 'closed']);
        return redirect()->route('tickets.index')->with('success', 'Ticket fermé avec succès!');
    }

    public function addMessage(Request $request, $ticketId)
    {
        $yourticket = Ticket::with('category', 'user')
        ->orderByRaw("FIELD(status, 'open') DESC")
        ->orderBy('created_at', 'desc')
        ->where("user_id",Auth::id())
        ->where('id', $ticketId)
        ->get();
    if ($yourticket->isEmpty()) {
        abort(404);
        }
        $request->validate(['message' => 'required|string']);

        TicketMessage::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }
}
