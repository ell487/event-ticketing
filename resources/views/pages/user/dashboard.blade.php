@extends('layouts.master')

@section('content')
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-white">👋 Welcome, {{ Auth::user()->name }}!</h3>
        <p class="text-slate-400 mt-1">Siap untuk seru-seruan? Yuk cari event favoritmu.</p>
    </div>

    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 shadow-xl flex justify-between items-center mb-8">
        <div>
            <h4 class="text-2xl font-bold text-white mb-2">Konser Musik Terbesar Tahun Ini!</h4>
            <p class="text-indigo-100 mb-4">Dapatkan diskon 20% untuk pembelian tiket presale.</p>
            <button class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-bold hover:bg-slate-100 transition">
                Lihat Event
            </button>
        </div>
        <div class="hidden md:block text-6xl">
            🎸
        </div>
    </div>

    <h4 class="text-xl font-bold text-white mb-4">Tiket Aktif Saya</h4>
    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 text-center">
        <p class="text-slate-400">Kamu belum memiliki tiket event yang aktif.</p>
        <button class="mt-4 bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg font-semibold transition">
            Cari Event Sekarang
        </button>
    </div>
@endsection
