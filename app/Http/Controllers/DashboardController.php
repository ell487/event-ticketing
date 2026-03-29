<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Ticket;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
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
    // Fungsi khusus untuk Organizer melihat daftar event
    public function myEvents()
    {
        $user = Auth::user();

        // Ambil event yang cuma milik organizer yang lagi login
        $events = Event::where('organizer_id', $user->id)->latest()->get();

        // Arahkan ke file view khusus organizer yang tadi baru dibikin
        return view('pages.organizer.events.index', compact('events'));
    }

    // FUNGSI ACC PEMBAYARAN ORGANIZER
   public function approveTransaction($id)
    {
        $transaction = Transaction::with('details')->findOrFail($id);

        if ($transaction->event->organizer_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah transaksi ini.');
        }

        DB::beginTransaction();
        try {
            // 1. Ubah status jadi Lunas ('paid')
            $transaction->update(['transaction_status' => 'paid']);

            // 2. POTONG KUOTA & CETAK TIKET (Pindahan dari PaymentController)
            foreach ($transaction->details as $detail) {
                // Kurangi kuota
                $ticketType = TicketType::find($detail->ticket_type_id);
                $ticketType->increment('sold_quantity', $detail->quantity);

                // Cetak E-Ticket
                for ($i = 0; $i < $detail->quantity; $i++) {
                    $ticketCode = 'TIX-' . strtoupper(Str::random(8));
                    $qrCodeFileName = 'qrcodes/' . $ticketCode . '.svg';
                    $qrCodeContent = QrCode::size(300)->generate($ticketCode);
                    Storage::disk('public')->put($qrCodeFileName, $qrCodeContent);

                    Ticket::create([
                        'transaction_detail_id' => $detail->id,
                        'ticket_code' => $ticketCode,
                        'qr_code_path' => $qrCodeFileName,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran di-ACC! E-Ticket untuk pembeli telah diterbitkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses tiket: ' . $e->getMessage());
        }
    }

    // FUNGSI TOLAK PEMBAYARAN
    public function rejectTransaction($id)
    {
        // 1. Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // 2. Keamanan
        if ($transaction->event->organizer_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah transaksi ini.');
        }

        // 3. Ubah status jadi Gagal/Ditolak
        $transaction->update([
            'transaction_status' => 'failed'
        ]);

        // 4. Balik ke halaman sebelumnya bawa pesan sukses
        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }
}
