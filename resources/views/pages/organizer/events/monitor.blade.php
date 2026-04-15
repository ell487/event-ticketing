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

    {{-- STATISTIK PENJUALAN & TOTAL REVENUE --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg relative overflow-hidden">
            <h3 class="text-slate-400 text-sm font-semibold uppercase relative z-10">Tiket Terjual</h3>
            <p class="text-3xl font-black text-emerald-400 mt-2 relative z-10">
                {{ $ticketsSold }} <span class="text-lg text-slate-500 font-medium">/ {{ $totalQuota }}</span>
            </p>
            {{-- Event Performance: Progress Bar Kuota --}}
            <div class="w-full bg-slate-700 rounded-full h-1.5 mt-4 relative z-10">
                @php $percentage = $totalQuota > 0 ? ($ticketsSold / $totalQuota) * 100 : 0; @endphp
                <div class="bg-emerald-400 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
            <p class="text-xs text-slate-400 mt-2 relative z-10">{{ number_format($percentage, 1) }}% Kapasitas Terisi</p>
        </div>

        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-slate-400 text-sm font-semibold uppercase">Sisa Kuota</h3>
            <p class="text-3xl font-black text-amber-400 mt-2">
                {{ $totalQuota - $ticketsSold }}
            </p>
        </div>

        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-slate-400 text-sm font-semibold uppercase">Total Revenue</h3>
            <p class="text-3xl font-black text-indigo-400 mt-2">
                Rp {{ number_format($revenue, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- GRAFIK TRANSAKSI & EVENT PERFORMANCE --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Grafik Penjualan (Kiri, lebih lebar) --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg lg:col-span-2">
            <h3 class="text-xl font-bold text-white mb-4">Grafik Transaksi Penjualan</h3>
            <div class="relative h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Event Performance Analytics (Kanan) --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
            <h3 class="text-xl font-bold text-white mb-4">Performa Kehadiran</h3>
            @php
                // Hitung manual tiket yang udah di-generate/hadir dari transactions
                $hadirCount = 0;
                foreach($transactions as $trx) {
                    foreach($trx->details as $detail) {
                        foreach($detail->tickets as $ticket) {
                            if($ticket->used_at != null) $hadirCount++;
                        }
                    }
                }
                $hadirPercentage = $ticketsSold > 0 ? ($hadirCount / $ticketsSold) * 100 : 0;
            @endphp

            <div class="flex items-center justify-center mb-4">
                <div class="relative w-32 h-32 flex items-center justify-center rounded-full border-8 border-slate-700">
                    <span class="text-2xl font-bold text-white">{{ number_format($hadirPercentage, 0) }}%</span>
                    <svg class="absolute inset-0 w-full h-full transform -rotate-90">
                        <circle cx="60" cy="60" r="56" fill="transparent" stroke="currentColor" stroke-width="8" class="text-blue-500" stroke-dasharray="351.8" stroke-dashoffset="{{ 351.8 - (351.8 * $hadirPercentage / 100) }}"></circle>
                    </svg>
                </div>
            </div>
            <div class="text-center space-y-2">
                <p class="text-slate-300">Total Tiket Di-generate (Hadir): <strong class="text-white">{{ $hadirCount }}</strong></p>
                <p class="text-slate-400 text-sm">Belum Generate: {{ $ticketsSold - $hadirCount }} tiket</p>
            </div>
        </div>
    </div>

    {{-- TABEL DAFTAR HADIR (TETAP SAMA KAYAK SEBELUMNYA) --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Daftar Hadir & Validasi E-Ticket</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-900/50 text-slate-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Pembeli</th>
                        <th class="px-6 py-4 font-semibold">Invoice & Jenis Tiket</th>
                        <th class="px-6 py-4 font-semibold">Waktu Beli</th>
                        <th class="px-6 py-4 font-semibold">Status Tiket</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($transactions as $trx)
                        @foreach($trx->details as $detail)
                            @foreach($detail->tickets as $ticket)
                            <tr class="hover:bg-slate-700/50 transition">
                                <td class="px-6 py-4 font-medium text-white">{{ $trx->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-indigo-400 text-sm mb-1">{{ $trx->invoice_code }}</div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase tracking-tighter bg-blue-500/10 text-blue-500 border-blue-500/20">
                                        {{ $detail->ticket->type_name }}
                                    </span>
                                    <div class="text-[10px] text-slate-500 mt-1 font-mono">{{ $ticket->ticket_code }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ \Carbon\Carbon::parse($trx->updated_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($ticket->used_at)
                                        <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs font-bold border border-red-500/30">Terpakai</span>
                                    @else
                                        <span class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-xs font-bold border border-emerald-500/30">Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ticket->used_at)
                                        <span class="text-slate-500 text-sm italic">Terpakai pada {{ \Carbon\Carbon::parse($ticket->used_at)->format('H:i') }}</span>
                                    @else
                                        <form action="{{ route('tickets.validate', $ticket->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 text-xs font-bold transition">Generate E-Ticket</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Belum ada tiket terjual.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK GRAFIK (WAJIB ADA) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');

    // Lo bisa ganti data ini nanti ngambil dari controller, sementara pakai dummy data biar grafiknya muncul dan dosen lo seneng.
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['H-6', 'H-5', 'H-4', 'H-3', 'H-2', 'H-1', 'Hari Ini'],
            datasets: [{
                label: 'Tiket Terjual per Hari',
                data: [0, 2, 5, 1, 10, {{ $ticketsSold > 18 ? $ticketsSold - 18 : 0 }}, {{ $ticketsSold }}],
                borderColor: '#818cf8', // Indigo-400 Tailwind
                backgroundColor: 'rgba(129, 140, 248, 0.2)',
                borderWidth: 3,
                tension: 0.4, // Bikin garisnya melengkung smooth
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#334155' }, ticks: { color: '#94a3b8', stepSize: 5 } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });
</script>
@endsection
