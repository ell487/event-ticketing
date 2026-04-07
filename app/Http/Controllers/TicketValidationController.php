<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketValidationController extends Controller
{
    public function validateTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->used_at = now();
        $ticket->save();

        return back()->with('success', 'Tiket berhasil dikonfirmasi hadir!');
    }
}
