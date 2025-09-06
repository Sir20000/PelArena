<?php

namespace App\Http\Controllers\Clients;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\TicketMessage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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

        $ticket = Ticket::create([
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);
    $webhookUrl = settings('webhook_ticket'); // Récupère le webhook depuis les settings

    if ($webhookUrl) {
        $embed = [
            'title' => '📩 Nouveau ticket ouvert',
            'color' => hexdec('7289DA'), // Bleu Discord
            'fields' => [
                [
                    'name' => '🎫 Titre',
                    'value' => $ticket->title,
                    'inline' => false
                ],
                [
                    'name' => '📝 Description',
                    'value' => $ticket->description,
                    'inline' => false
                ],
                [
                    'name' => '🔗 Lien',
                    'value' => route('tickets.show', $ticket->id),
                    'inline' => false
                ],
            ],
            'footer' => [
                'text' => 'Système de tickets',
            ],
            'timestamp' => now()->toIso8601String(),
        ];

        Http::post($webhookUrl, [
            'embeds' => [$embed],
            'username' => 'Ticket Bot',
            'avatar_url' => 'https://i.imgur.com/4M34hi2.png', // Avatar personnalisé (facultatif)
        ]);
    }
        return redirect()->route('tickets.index')->with('success', 'Ticket ouvert avec succès!');
    }

    public function show($ticketId)
    {
        CheckTicket($ticketId);
        $ticket = Ticket::findOrFail($ticketId);
        $messages = TicketMessage::where('ticket_id', $ticketId)->get();
        return view('client.tickets.show', compact('ticket', 'messages'));
    }

    public function close($id)
    {         CheckTicket($id);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => 'closed']);
        return redirect()->route('tickets.index')->with('success', 'Ticket fermé avec succès!');
    }

    public function addMessage(Request $request, $ticketId)
    {
        CheckTicket($ticketId);

        $request->validate(['message' => 'required|string']);

        TicketMessage::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }
}
