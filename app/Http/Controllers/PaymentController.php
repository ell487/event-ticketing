<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TicketType;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
   public function show($invoice_code)
    {
        $transaction = Transaction::with(['event', 'details.ticket'])
                        ->where('invoice_code', $invoice_code)

                        ->firstOrFail();


        if ($transaction->transaction_status === 'failed' || \Carbon\Carbon::now()->greaterThan($transaction->expiration_date)) {


            if ($transaction->transaction_status !== 'failed') {
                $transaction->update(['transaction_status' => 'failed']);
            }

            // Tendang user balik ke halaman tiket bawa pesan error
            return redirect()->route('user.tickets.index')->with('error', 'Yahh, batas waktu pembayaran untuk tiket ini sudah habis ');
        }


        if ($transaction->transaction_status === 'paid') {
            return redirect()->route('user.tickets.index')->with('success', 'Tiket ini sudah lunas kok');
        }

        return view('pages.user.payment.show', compact('transaction'));
    }

   public function process(Request $request, $invoice_code)
    {
        // 1. Validasi! Pastikan user beneran upload gambar dan ukurannya gak kegedean (Max 2MB)
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Bukti transfer wajib diupload ya.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $transaction = Transaction::with('details.ticket')->where('invoice_code', $invoice_code)->firstOrFail();

        DB::beginTransaction();
        try {
            // 2. Logika Upload Gambar
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                // Simpan ke storage/app/public/payment_proofs
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            // 3. Update data transaksi di database
            $transaction->update([
                'payment_proof' => $paymentProofPath,
                'transaction_status' => 'pending', // Ubah status jadi pending biar nunggu di-ACC panitia
            ]);

            DB::commit();
            return redirect()->route('user.tickets.index')->with('success', 'Konfirmasi pembayaran berhasil dikirim! Silakan tunggu Organizer melakukan ACC.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Konfirmasi gagal: ' . $e->getMessage());
        }
    }


}
