@extends('layouts.master') @section('content')
<div class="p-6 text-white min-h-screen">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Laporan Transaksi Sistem</h1>
        <p class="mt-1 text-slate-400">Pantau seluruh riwayat transaksi dari semua event dan organizer.</p>
    </div>

    <div class="overflow-x-auto bg-slate-800 rounded-lg shadow-lg">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-sm border-b border-slate-700 bg-slate-900/50">
                    <th class="p-4 font-semibold text-slate-300">TANGGAL</th>
                    <th class="p-4 font-semibold text-slate-300">INVOICE</th>
                    <th class="p-4 font-semibold text-slate-300">PEMBELI</th>
                    <th class="p-4 font-semibold text-slate-300">NAMA EVENT</th>
                    <th class="p-4 font-semibold text-slate-300">STATUS</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($transactions as $trx)
                <tr class="border-b border-slate-700 hover:bg-slate-700/50">
                    <td class="p-4 text-slate-400">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4 font-bold text-indigo-400">{{ $trx->invoice_code }}</td>
                    <td class="p-4 text-slate-200">{{ $trx->user->name }}</td>
                    <td class="p-4 text-slate-200">{{ $trx->event->title ?? 'Event Dihapus' }}</td>
                    <td class="p-4">
                        @if($trx->transaction_status == 'paid')
                            <span class="px-3 py-1 text-xs text-green-400 bg-green-400/10 rounded-full border border-green-400/20">Berhasil</span>
                        @elseif($trx->transaction_status == 'pending')
                            <span class="px-3 py-1 text-xs text-yellow-400 bg-yellow-400/10 rounded-full border border-yellow-400/20">Pending</span>
                        @else
                            <span class="px-3 py-1 text-xs text-red-400 bg-red-400/10 rounded-full border border-red-400/20">Gagal/Batal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">Belum ada transaksi di dalam sistem.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
