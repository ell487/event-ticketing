@extends('layouts.master')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h3 class="text-3xl font-bold text-white">🎪 Organizer Dashboard</h3>
            <p class="text-slate-400 mt-1">Kelola event kamu dan pantau penjualan tiket.</p>
        </div>
        <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg transition">
            + Buat Event Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Event Aktif Saya</p>
            <h4 class="text-4xl font-bold text-blue-400">3</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Tiket Terjual</p>
            <h4 class="text-4xl font-bold text-green-400">850</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Pendapatan Saya</p>
            <h4 class="text-4xl font-bold text-yellow-400">Rp 45M</h4>
        </div>
    </div>
@endsection
