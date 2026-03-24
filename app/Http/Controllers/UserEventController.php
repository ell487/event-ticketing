<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    // Menampilkan semua event untuk halaman "Cari Event"
    public function index()
    {
        // Ambil semua event, urutkan dari yang paling baru/terdekat,
        // dan bawa juga data kategorinya biar gampang ditampilin
        $events = Event::with('category')->orderBy('event_date', 'asc')->get();

        return view('pages.user.events.index', compact('events'));
    }

    // Menampilkan Detail Event dan Pilihan Tiket
    public function show($id)
    {
        // Ambil data event sekalian narik data kategori dan jenis tiketnya
        $event = Event::with(['category', 'ticketTypes'])->findOrFail($id);

        return view('pages.user.events.show', compact('event'));
    }
}
