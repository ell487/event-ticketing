<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    // Simpan tiket baru ke event tertentu
    public function store(Request $request, $eventId)
    {
        // Validasi inputan admin
        $request->validate([
            'type_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        // Simpan ke database
        TicketType::create([
            'event_id' => $eventId,
            'type_name' => $request->type_name,
            'price' => $request->price,
            'quota' => $request->quota,
            'sold_quantity' => 0, // Awal dibuat pasti belum ada yang laku
        ]);

        // Kembalikan ke halaman yang sama dengan pesan sukses
        return back()->with('success', 'Berhasil menambahkan jenis tiket baru!');
    }

    // Hapus tiket
    public function destroy($id)
    {
        $ticket = TicketType::findOrFail($id);
        $ticket->delete();

        return back()->with('success', 'Jenis tiket berhasil dihapus!');
    }
}
