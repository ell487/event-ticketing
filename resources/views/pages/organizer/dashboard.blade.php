@extends('layouts.master')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h3 class="text-3xl font-bold text-white">Organizer Dashboard</h3>
            <p class="text-slate-400 mt-1">Kelola event kamu dan pantau penjualan tiket.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Event Aktif Saya</p>
            <h4 class="text-4xl font-bold text-blue-400">{{ $activeEvents ?? 0 }}</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Tiket Terjual</p>
            <h4 class="text-4xl font-bold text-green-400">{{ $ticketsSold ?? 0 }}</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Pendapatan Saya</p>
            <h4 class="text-4xl font-bold text-amber-400">Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>


    <div class="mt-8 bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-white">Analitik Penjualan</h3>
                <p class="text-slate-400 text-sm">Tren transaksi lunas dalam 7 hari terakhir.</p>
            </div>
            
        </div>

        <div class="h-[350px] w-full">
            <canvas id="organizerSalesChart"></canvas>
        </div>
    </div>

    <div class="mt-10">
        <h3 class="text-xl font-bold text-white mb-4">Persetujuan Tiket & Pembayaran</h3>

        @if(session('success'))
            <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-xl mb-6 font-medium">
                 {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-slate-300">
                    <thead class="bg-slate-900/50 text-slate-400 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                            <th class="px-6 py-4 font-semibold">Pembeli</th>
                            <th class="px-6 py-4 font-semibold">Event</th>
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                            <th class="px-6 py-4 font-semibold text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($transactions ?? [] as $index => $transaction)
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-white">{{ $transaction->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-400">{{ $transaction->event->title }}</td>

                            <td class="px-6 py-4 text-center">
                                @if($transaction->transaction_status == 'pending')
                                    <span class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-full text-xs font-semibold border border-amber-500/30">Menunggu ACC</span>
                                @elseif($transaction->transaction_status == 'paid')
                                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold border border-emerald-500/30">Lunas</span>
                                @else
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-semibold border border-red-500/30">Gagal / Ditolak</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 flex justify-center gap-2">
                                @if($transaction->transaction_status == 'pending')
                                    <form action="{{ route('organizer.transactions.approve', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white p-2 rounded-lg transition border border-emerald-500/30 hover:border-emerald-500" title="Terima Pembayaran">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('organizer.transactions.reject', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded-lg transition border border-red-500/30 hover:border-red-500" title="Tolak Pembayaran">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-500 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada transaksi tiket masuk untuk event kamu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('organizerSalesChart');
        if (!canvas) {
            console.error("Canvas element tidak ditemukan!");
            return;
        }

        const ctx = canvas.getContext('2d');

        // Ambil data dari PHP, kalau error/kosong kasih array kosong
        let labels = {!! json_encode($chartLabels ?? []) !!};
        let dataValues = {!! json_encode($chartValues ?? []) !!};

        // Jika belum ada data transaksi sama sekali, tampilkan grafik dummy 0
        if (labels.length === 0) {
            labels = ['H-6', 'H-5', 'H-4', 'H-3', 'H-2', 'H-1', 'Hari Ini'];
            dataValues = [0, 0, 0, 0, 0, 0, 0];
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tiket Terjual',
                    data: dataValues,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: {
                            color: '#94a3b8',
                            stepSize: 1, // Pastikan angkanya bulat (1, 2, 3 tiket)
                            precision: 0
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    });
</script>
@endpush
