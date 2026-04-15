@extends('layouts.master')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-2xl font-bold text-white">Edit Tiket</h3>
        <a href="{{ url()->previous() }}" class="text-slate-400 hover:text-white transition">Kembali</a>
    </div>

    <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 shadow-lg">
        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Tiket</label>
                <input type="text" name="type_name" value="{{ $ticket->type_name }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $ticket->price }}" required min="0" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Total Kuota (Ubah angka ini buat nambah kuota)</label>
                <input type="number" name="quota" value="{{ $ticket->quota }}" required min="1" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-lg font-bold shadow transition mt-4">
                Update Tiket
            </button>
        </form>
    </div>
</div>
@endsection
