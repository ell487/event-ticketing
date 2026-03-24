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
            return redirect()->route('user.tickets.index')->with('error', 'Yahh, batas waktu pembayaran untuk tiket ini sudah habis 😭');
        }


        if ($transaction->transaction_status === 'paid') {
            return redirect()->route('user.tickets.index')->with('success', 'Tiket ini sudah lunas kok!');
        }

        return view('pages.user.payment.show', compact('transaction'));
    }

    public function process(Request $request, $invoice_code)
    {
        $transaction = Transaction::with('details.ticket')->where('invoice_code', $invoice_code)->firstOrFail();

        if ($transaction->transaction_status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah tidak valid.');
        }

        DB::beginTransaction();
        try {
            // A. UBAH STATUS TRANSAKSI
            $transaction->update(['transaction_status' => 'paid']);

            // B. POTONG KUOTA & CETAK TIKET
            foreach ($transaction->details as $detail) {
                // 1. Kurangi kuota (tambah sold_quantity)
                $ticketType = TicketType::find($detail->ticket_type_id);
                $ticketType->increment('sold_quantity', $detail->quantity);

                // 2. Cetak E-Ticket sebanyak jumlah yang dibeli (quantity)
                for ($i = 0; $i < $detail->quantity; $i++) {
                    // Bikin kode unik (Contoh: TIX-A1B2C3D4)
                    $ticketCode = 'TIX-' . strtoupper(Str::random(8));

                    // nama file QR Code
                    $qrCodeFileName = 'qrcodes/' . $ticketCode . '.svg';

                    // Generate gambar QR Code
                    $qrCodeContent = QrCode::size(300)->generate($ticketCode);

                    // Simpan gambar QR ke folder storage/app/public/qrcodes
                    Storage::disk('public')->put($qrCodeFileName, $qrCodeContent);

                    // Simpan ke database tabel 'tickets'
                    Ticket::create([
                        'transaction_detail_id' => $detail->id,
                        'ticket_code' => $ticketCode,
                        'qr_code_path' => $qrCodeFileName,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('user.tickets.index')->with('success', 'Pembayaran Berhasil! E-Ticket kamu sudah terbit.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Pembayaran gagal: ' . $e->getMessage());
        }
    }
}
