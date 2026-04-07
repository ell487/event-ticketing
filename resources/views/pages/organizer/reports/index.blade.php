@extends('layouts.master') @section('content')
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

    <div class="overflow-x-auto bg-slate-800 rounded-lg shadow">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-sm border-b border-slate-700 bg-slate-800/50">
                    <th class="p-4 font-semibold text-slate-300">TANGGAL</th>
                    <th class="p-4 font-semibold text-slate-300">INVOICE</th>
                    <th class="p-4 font-semibold text-slate-300">PEMBELI</th>
                    <th class="p-4 font-semibold text-slate-300">EVENT</th>
                    <th class="p-4 font-semibold text-slate-300">STATUS</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($transactions as $trx)
                <tr class="border-b border-slate-700 hover:bg-slate-700/50">
                    <td class="p-4 text-slate-300">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4 font-medium text-indigo-400">{{ $trx->invoice_code }}</td>
                    <td class="p-4">{{ $trx->user->name }}</td>
                    <td class="p-4">{{ $trx->event->title }}</td>
                    <td class="p-4">
                        @if($trx->transaction_status == 'paid')
                            <span class="px-2 py-1 text-xs text-green-400 bg-green-400/10 rounded-full">Lunas</span>
                        @else
                            <span class="px-2 py-1 text-xs text-yellow-400 bg-yellow-400/10 rounded-full">Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
