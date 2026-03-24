<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    // Menampilkan daftar tiket / transaksi milik user yang sedang login
   public function index()
    {
        // Ambil transaksi milik user 
        $transactions = Transaction::with('event')
                        ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        //  PENGECEKAN KEDALUWARSA (EXPIRED)
        foreach ($transactions as $trx) {
            // Kalau statusnya masih pending, TAPI waktu sekarang sudah melewati batas waktu (expiration_date)
            if ($trx->transaction_status === 'pending' && \Carbon\Carbon::now()->greaterThan($trx->expiration_date)) {


                $trx->update([
                    'transaction_status' => 'failed'
                ]);

                // 2. Ubah juga data yang lagi dibaca saat ini biar langsung merah di layar
                $trx->transaction_status = 'failed';
            }
        }

        return view('pages.user.transactions.index', compact('transactions'));
    }

    // Menampilkan detail E-Ticket
    public function show($invoice_code)
    {

        $transaction = Transaction::with(['event', 'details.ticket', 'details.tickets'])
                        ->where('invoice_code', $invoice_code)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        return view('pages.user.transactions.show', compact('transaction'));
    }
}
