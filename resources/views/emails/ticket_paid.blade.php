<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { background: #4f46e5; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #888; margin-top: 20px; }
        .ticket-box { margin-bottom: 20px; padding: 15px; border: 2px dashed #4f46e5; text-align: center; border-radius: 8px; background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pembayaran Berhasil! 🎟️</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $transaction->user->name }}</strong>!</p>
            <p>Kabar baik! Pembayaran lo untuk invoice <strong>{{ $transaction->invoice_code }}</strong> udah berhasil diverifikasi oleh panitia.</p>

            <p><strong>Detail Event:</strong><br>
            Nama Event: {{ $transaction->event->title }}</p>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

            <h3 style="text-align: center;">Ini E-Ticket & QR Code Lo:</h3>

            {{-- Looping untuk nyari dan nampilin semua tiket yang dibeli di transaksi ini --}}
            @foreach($transaction->details as $detail)
                @php
                    // Tarik data tiket dari database berdasarkan detail transaksi
                    $tickets = \App\Models\Ticket::where('transaction_detail_id', $detail->id)->get();
                @endphp

                @foreach($tickets as $ticket)
                    <div class="ticket-box">
                        <p style="margin: 0; font-size: 14px; color: #666;">Kode Tiket:</p>
                        <h3 style="margin: 5px 0; color: #4f46e5; letter-spacing: 2px;">{{ $ticket->ticket_code }}</h3>

                        {{-- Ini baris untuk nampilin gambar QR Code-nya --}}
                        <img src="{{ url('storage/' . $ticket->qr_code_path) }}" alt="QR Code" style="width: 150px; height: 150px; margin-top: 10px;">
                    </div>
                @endforeach
            @endforeach

            <p style="text-align: center; font-size: 14px; color: #e11d48;">
                <em>*Tunjukkan QR Code di atas saat datang ke lokasi event ya!</em>
            </p>

            <br>
            <p>Sampai jumpa di lokasi!</p>
            <p>Tim {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <p>Email ini di-generate otomatis oleh sistem. Jangan balas email ini ya.</p>
        </div>
    </div>
</body>
</html>
