@extends('layouts.master')

@section('content')
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-white">Super Admin Dashboard</h3>
        <p class="text-slate-400 mt-1">Pantau semua aktivitas event dan transaksi di sistem.</p>
    </div>

    <div class="mb-6 flex gap-4">
        <a href="{{ route('events.index') }}" class="bg-slate-700 hover:bg-slate-600 text-white px-5 py-2.5 rounded-lg font-bold border border-slate-600 transition">
            Lihat Daftar Event
        </a>
        <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg transition">
            + Buat Event Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Seluruh Event</p>
            <h4 class="text-4xl font-bold text-blue-400">{{ $totalEvents }}</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Organizer</p>
            <h4 class="text-4xl font-bold text-green-400">{{ $totalOrganizers }}</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Pendapatan Sistem</p>
            <h4 class="text-4xl font-bold text-yellow-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
        </div>
    </div>
@endsection
