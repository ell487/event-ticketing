@extends('layouts.master')
@section('content')
<div class="flex flex-col items-start justify-between mb-6 md:flex-row md:items-center">
    <div class="mb-4 md:mb-0">
        <h1 class="text-3xl font-bold">Laporan Penjualan</h1>
        <p class="mt-1 text-slate-400">Rekap data transaksi untuk semua event Anda.</p>
    </div>

    <a href="{{ route('organizer.reports.pdf') }}" class="inline-flex items-center justify-center px-4 py-2 font-semibold text-white transition duration-200 ease-in-out bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        Export PDF
    </a>
</div>

{{-- Alert Success/Error (Biar ada notif pas abis nge-ACC) --}}
@if(session('success'))
    <div class="mb-4 p-4 bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 rounded-xl text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-slate-800 rounded-lg shadow">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="text-sm border-b border-slate-700 bg-slate-800/50">
                <th class="p-4 font-semibold text-slate-300">TANGGAL</th>
                <th class="p-4 font-semibold text-slate-300">INVOICE</th>
                <th class="p-4 font-semibold text-slate-300">PEMBELI</th>
                <th class="p-4 font-semibold text-slate-300">EVENT</th>
                <th class="p-4 font-semibold text-slate-300 text-center">BUKTI BAYAR</th>
                <th class="p-4 font-semibold text-slate-300 text-center">STATUS</th>
                <th class="p-4 font-semibold text-slate-300 text-center">AKSI</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @forelse($transactions as $trx)
            <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition">
                <td class="p-4 text-slate-300">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                <td class="p-4 font-medium text-indigo-400">{{ $trx->invoice_code }}</td>
                <td class="p-4">{{ $trx->user->name }}</td>
                <td class="p-4">{{ $trx->event->title }}</td>

                {{-- TAMBAHAN: Kolom Bukti Bayar --}}
                <td class="p-4 text-center">
                    @if($trx->payment_proof)
                        <a href="{{ asset('storage/' . $trx->payment_proof) }}" target="_blank"
                           class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-blue-400 transition bg-blue-500/10 rounded-lg hover:bg-blue-500 hover:text-white border border-blue-500/30">
                            Lihat Struk
                        </a>
                    @else
                        <span class="text-xs italic text-slate-500">Belum ada</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    @if($trx->transaction_status == 'paid')
                        <span class="px-2 py-1 text-xs text-emerald-400 bg-emerald-400/10 border border-emerald-400/20 rounded-full font-bold">Lunas</span>
                    @elseif($trx->transaction_status == 'pending')
                        <span class="px-2 py-1 text-xs text-amber-400 bg-amber-400/10 border border-amber-400/20 rounded-full font-bold">Pending</span>
                    @else
                        <span class="px-2 py-1 text-xs text-red-400 bg-red-400/10 border border-red-400/20 rounded-full font-bold">Gagal</span>
                    @endif
                </td>

                {{-- Kolom Aksi (ACC / Tolak) --}}
                <td class="p-4 flex justify-center gap-2">
                    @if($trx->transaction_status == 'pending')
                        {{-- Form ACC --}}
                        <form action="{{ route('organizer.transactions.approve', $trx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg shadow transition">
                                ACC
                            </button>
                        </form>

                        {{-- Form Tolak --}}
                        <form action="{{ route('organizer.transactions.reject', $trx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Yakin ingin menolak pembayaran ini?')" class="px-3 py-1.5 text-xs font-bold text-red-400 hover:text-white bg-red-500/10 hover:bg-red-500 border border-red-500/20 hover:border-red-500 rounded-lg shadow transition">
                                Tolak
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-slate-500 italic">- Selesai -</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
