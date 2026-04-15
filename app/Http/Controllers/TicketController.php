<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function edit($id)
{
    // Cari tiket berdasarkan ID
    $ticket = \App\Models\TicketType::findOrFail($id); // Sesuaikan nama model Tiket lo

    return view('pages.admin.events.edit-ticket', compact('ticket'));
}

public function update(Request $request, $id)
{
    $ticket = \App\Models\TicketType::findOrFail($id); // Sesuaikan nama model Tiket lo

    // Update data tiket, terutama KUOTA
    $ticket->update([
        'type_name' => $request->type_name,
        'price' => $request->price,
        'quota' => $request->quota,
    ]);

    // Balik ke halaman Kelola Tiket event tersebut
    return redirect()->route('events.show', $ticket->event_id) // Sesuaikan nama route lo buat balik ke halaman kelola tiket
                     ->with('success', 'Berhasil! Data tiket & kuota sudah diupdate.');
}
}
