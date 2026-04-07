<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // --- 1. FUNGSI BUKA HALAMAN LAPORAN (HANYA ORGANIZER) ---
    public function index()
    {
        // Cari ID event yang dimiliki sama Organizer yang lagi login
        $eventIds = Event::where('organizer_id', Auth::id())->pluck('id');

        // Tarik data transaksi khusus untuk event-event milik si Organizer
        $transactions = Transaction::whereIn('event_id', $eventIds)
                        ->with(['user', 'event'])
                        ->latest()
                        ->get();

        // Tampilkan halaman web-nya
        return view('pages.organizer.reports.index', compact('transactions'));
    }

    // --- 2. FUNGSI KLIK TOMBOL EXPORT PDF (HANYA ORGANIZER) ---
    public function exportPdf()
    {
        // Tarik data yang sama kayak di atas
        $eventIds = Event::where('organizer_id', Auth::id())->pluck('id');

        $transactions = Transaction::whereIn('event_id', $eventIds)
                        ->with(['user', 'event'])
                        ->latest()
                        ->get();

        // Load data
        $pdf = Pdf::loadView('pages.organizer.reports.pdf', compact('transactions'));

        // Download file PDF
        return $pdf->download('laporan-penjualan-tixevent.pdf');
    }

    public function exportReport($event_id)
    {
        $event = Event::with('transactions.user', 'transactions.details.ticket')->findOrFail($event_id);
        $pdf = Pdf::loadView('pages.organizer.report_pdf', compact('event'));
        return $pdf->download('Laporan-Penjualan-'. $event->title .'.pdf');
    }


    public function adminIndex()
    {
        // Admin narik data transaksi dari semua event & semua user
        $transactions = Transaction::with(['user', 'event.organizer'])
                        ->latest()
                        ->paginate(20); // Pake paginate biar admin ga lemot kalo data udah ribuan

        return view('pages.admin.reports.index', compact('transactions'));
    }
}
