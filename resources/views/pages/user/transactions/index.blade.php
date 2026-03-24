@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <h2 class="text-3xl font-black text-white mb-6"> Tiket Saya</h2>

    @if(session('success'))
        <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-xl mb-6 font-medium">
             {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-900/50 text-slate-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Invoice</th>
                        <th class="px-6 py-4 font-semibold">Event</th>
                        <th class="px-6 py-4 font-semibold">Batas Waktu</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4 font-mono text-indigo-400">{{ $trx->invoice_code }}</td>
                        <td class="px-6 py-4 font-medium text-white">{{ $trx->event->title ?? 'Event Dihapus' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-400">
                            {{ \Carbon\Carbon::parse($trx->expiration_date)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->transaction_status === 'pending')
                                <span class="bg-amber-500/20 text-amber-400 px-3 py-1 rounded-full text-xs font-bold border border-amber-500/30">PENDING</span>
                            @elseif($trx->transaction_status === 'paid')
                                <span class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold border border-emerald-500/30">PAID</span>
                            @else
                                <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs font-bold border border-red-500/30">FAILED</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($trx->transaction_status === 'pending')
                                <a href="{{ route('payment.show', $trx->invoice_code) }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shadow-md">
                                    Bayar Sekarang
                                </a>
                            @elseif($trx->transaction_status === 'paid')
                                <a href="{{ route('user.tickets.show', $trx->invoice_code) }}" class="inline-block bg-slate-700 hover:bg-slate-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition border border-slate-600">
                                    Lihat E-Ticket
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Belum ada tiket yang kamu pesan. Yuk cari event seru!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
