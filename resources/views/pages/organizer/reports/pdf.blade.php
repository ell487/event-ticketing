<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan TixEvent</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        table { w-full; border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-lunas { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan TixEvent</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Pembeli</th>
                <th>Event</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $trx->invoice_code }}</td>
                <td>{{ $trx->user->name }}</td>
                <td>{{ $trx->event->title }}</td>
                <td>
                    @if($trx->transaction_status == 'paid')
                        <span class="status-lunas">Lunas</span>
                    @else
                        <span class="status-pending">Pending</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
