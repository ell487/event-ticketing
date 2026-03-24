<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    // Menampilkan halaman Checkout
    public function index($ticketId)
    {
        $ticket = TicketType::with('event')->findOrFail($ticketId);
        return view('pages.user.checkout.index', compact('ticket'));
    }

    // Proses simpan pesanan ke DUA TABEL
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $ticket = TicketType::findOrFail($ticketId);
        $sisaKuota = $ticket->quota - $ticket->sold_quantity;

        // Cek kuota
        if ($request->quantity > $sisaKuota) {
            return back()->with('error', 'Jumlah tiket melebihi kuota yang tersedia!');
        }

        // Mulai proses simpan data dengan aman
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel 'transactions' (Header/Master)
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'event_id' => $ticket->event_id,
                'invoice_code' => 'INV-' . strtoupper(Str::random(8)), // Bikin kode unik misal: INV-X7B9K2M
                'expiration_date' => Carbon::now()->addHours(24), // Kasih waktu 24 jam buat bayar
                'transaction_status' => 'pending',
            ]);

            // 2. Simpan ke tabel 'transaction_details' (Isi keranjangnya)
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'ticket_type_id' => $ticket->id,
                'quantity' => $request->quantity,
            ]);

            // Kalau sukses semua, kunci permanen di database!
            DB::commit();

            // Arahkan ke halaman utama dulu bawa pesan sukses
            return redirect()->route('user.events.index')->with('success', 'Berhasil! Invoice ' . $transaction->invoice_code . ' telah dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            // Kalau ada error di tengah jalan, batalkan semua simpanan!
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
