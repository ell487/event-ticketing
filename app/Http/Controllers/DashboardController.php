<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User; // Pastikan Model User dipanggil untuk ngitung jumlah organizer

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {

            // DATA UNTUK DASHBOARD ADMIN

            // 1. Hitung total semua event di sistem
            $totalEvents = Event::count();

            // 2. Hitung total user yang role-nya organizer
            $totalOrganizers = User::where('role', 'organizer')->count();

            // 3. Hitung total pendapatan seluruh sistem
            $successfulTransactions = Transaction::with(['details.ticket'])
                                        ->where('transaction_status', 'paid')
                                        ->get();

            $totalRevenue = 0;
            foreach ($successfulTransactions as $transaction) {
                foreach ($transaction->details as $detail) {
                    // Tambahkan pendapatan: quantity x harga tiket
                    $totalRevenue += ($detail->quantity * ($detail->ticket->price ?? 0));
                }
            }

            // Kirim data ke tampilan Admin
            return view('pages.admin.dashboard', compact('totalEvents', 'totalOrganizers', 'totalRevenue'));

        } elseif ($user->role === 'organizer') {

            // DATA UNTUK DASHBOARD ORGANIZER
            $eventIds = Event::where('organizer_id', $user->id)->pluck('id');
            $activeEvents = $eventIds->count();

            $successfulTransactions = Transaction::with(['details.ticket'])
                                        ->whereIn('event_id', $eventIds)
                                        ->where('transaction_status', 'paid')
                                        ->get();

            $ticketsSold = 0;
            $revenue = 0;

            foreach ($successfulTransactions as $transaction) {
                foreach ($transaction->details as $detail) {
                    $ticketsSold += $detail->quantity;
                    $revenue += ($detail->quantity * ($detail->ticket->price ?? 0));
                }
            }

            $transactions = Transaction::with(['user', 'event'])
                                       ->whereIn('event_id', $eventIds)
                                       ->latest()
                                       ->get();

            return view('pages.organizer.dashboard', compact(
                'activeEvents',
                'ticketsSold',
                'revenue',
                'transactions'
            ));

        } else {
            // DATA UNTUK DASHBOARD USER
            return view('pages.user.dashboard');
        }
    }
}
