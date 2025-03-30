<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Ticket;
use App\Models\TicketMessage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::with('category', 'user')
            ->orderByRaw("FIELD(status, 'open') DESC")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show($ticketId)
    {
        
        $ticket = Ticket::findOrFail($ticketId);
        $messages = TicketMessage::where('ticket_id', $ticketId)->get();
        return view('admin.tickets.show', compact('ticket', 'messages'));
    }

    public function close($id)
    { 
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => 'closed']);
        return redirect()->route('tickets.index')->with('success', 'Ticket fermé avec succès!');
    }

    public function addMessage(Request $request, $ticketId)
    {
        
        $request->validate(['message' => 'required|string']);

        TicketMessage::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }

}
