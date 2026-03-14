@extends('layouts.master')

@section('content')
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-white">👑 Super Admin Dashboard</h3>
        <p class="text-slate-400 mt-1">Pantau semua aktivitas event dan transaksi di sistem.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Seluruh Event</p>
            <h4 class="text-4xl font-bold text-indigo-400">45</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Organizer</p>
            <h4 class="text-4xl font-bold text-green-400">12</h4>
        </div>
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-semibold mb-2">Total Pendapatan Sistem</p>
            <h4 class="text-4xl font-bold text-yellow-400">Rp 120M</h4>
        </div>
    </div>
@endsection
