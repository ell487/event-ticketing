<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAvailableNotification;

class WaitingListController extends Controller
{
    public function store($eventId)
    {
        // 1. Ambil ID user yang lagi login
        $userId = Auth::id();

        // 2. Cek jangan sampe user spam klik masuk waiting list berkali-kali di event yang sama
        $sudahNgantri = WaitingList::where('user_id', $userId)
                                   ->where('event_id', $eventId)
                                   ->exists();

        if ($sudahNgantri) {
            return back()->with('error', 'Lo udah masuk di antrean waiting list event ini.');
        }

        // 3. Kalau belum ada, masukin ke database
        WaitingList::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'status' => 'waiting' // Status default pas pertama kali daftar
        ]);

        return back()->with('success', 'Berhasil masuk daftar tunggu! Kami akan kabari kalau ada kuota kosong.');
    }
    public function organizerIndex()
    {
        $waitingLists = \App\Models\WaitingList::with('event', 'user')
            ->latest()
            ->get();

        return view('pages.organizer.waiting-list', compact('waitingLists'));
    }


    public function notifyManual($id)
    {
        // Cari data antriannya
        $waiting = WaitingList::with(['user', 'event'])->findOrFail($id);

        // Kirim email
        Mail::to($waiting->user->email)->send(new TicketAvailableNotification($waiting->user, $waiting->event));

        // Ubah statusnya dari waiting jadi notified
        $waiting->update(['status' => 'notified']);

        return back()->with('success', 'Email panggilan berhasil dikirim ke ' . $waiting->user->name . '!');
    }
}
