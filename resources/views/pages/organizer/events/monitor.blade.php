@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium mb-2 inline-block flex items-center gap-1">
                &larr; Kembali ke Event Saya
            </a>
            <h2 class="text-3xl font-black text-white">Pantau Penjualan</h2>
            <p class="text-slate-400 mt-1">Event: <span class="font-semibold text-white">{{ $event->title }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-slate-400 text-sm font-semibold uppercase">Tiket Terjual</h3>
            <p class="text-3xl font-black text-emerald-400 mt-2">
                {{ $ticketsSold }} <span class="text-lg text-slate-500 font-medium">/ {{ $totalQuota }}</span>
            </p>
        </div>
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-slate-400 text-sm font-semibold uppercase">Sisa Kuota</h3>
            <p class="text-3xl font-black text-amber-400 mt-2">
                {{ $totalQuota - $ticketsSold }}
            </p>
        </div>
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-slate-400 text-sm font-semibold uppercase">Pendapatan Sementara</h3>
            <p class="text-3xl font-black text-white mt-2">
                Rp {{ number_format($revenue, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Daftar Hadir (Guest List)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-900/50 text-slate-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Pembeli</th>
                        <th class="px-6 py-4 font-semibold">Invoice & Jenis Tiket</th>
                        <th class="px-6 py-4 font-semibold">Waktu Beli</th>
                        <th class="px-6 py-4 font-semibold">Status Tiket</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi (Validasi)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4 font-medium text-white">{{ $trx->user->name ?? 'Guest' }}</td>

                     <td class="px-6 py-4">
                            <div class="font-mono text-indigo-400 text-sm mb-1">{{ $trx->invoice_code }}</div>

                            <div class="flex flex-wrap gap-1">
                                @foreach ($trx->details as $detail)
                                    {{-- Cek VIP: pake ? (if) dan : (else) biar kodenya tipis --}}
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded border uppercase tracking-tighter
                                        {{ Str::contains(strtolower($detail->ticket->type_name), 'vip')
                                        ? 'bg-amber-500/10 text-amber-500 border-amber-500/20'
                                        : 'bg-blue-500/10 text-blue-500 border-blue-500/20' }}">
                                        {{ $detail->quantity }}x {{ $detail->ticket->type_name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400">
                            {{ \Carbon\Carbon::parse($trx->updated_at)->format('d M Y, H:i') }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold border border-emerald-500/30">
                                Aktif
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shadow-md">
                                Scan QR & Check-in
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">
                            Belum ada tiket yang terjual untuk event ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
