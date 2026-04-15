@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h3 class="text-3xl font-bold text-white"> Kelola Tiket Event</h3>
            <p class="text-slate-400 mt-1">Atur jenis tiket, harga, dan kuota untuk event ini.</p>
        </div>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-sm font-medium rounded-lg border border-slate-700 transition-all duration-200 shadow-sm group w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 group-hover:text-white group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 flex items-center gap-6 shadow-lg">
        @if($event->banner_path)
            <img src="{{ asset('storage/' . $event->banner_path) }}" class="w-32 h-20 object-cover rounded-lg border border-slate-600">
        @endif
        <div>
            <h4 class="text-2xl font-bold text-white">{{ $event->title }}</h4>
            <p class="text-slate-400 mt-1"> {{ $event->location }} |  {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</p>
            <span class="inline-block mt-2 bg-indigo-500/20 text-indigo-400 px-2.5 py-1 rounded-full text-xs font-semibold">
                Status: {{ ucfirst($event->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 shadow-lg lg:col-span-1 h-fit">
            <h5 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2"> Tambah Tiket Baru</h5>
            <form action="{{ route('tickets.store', $event->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Tiket (Contoh: VIP, Reguler, dll)</label>
                    <input type="text" name="type_name" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" required min="0" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500" placeholder="0 untuk gratis">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Total Kuota (Lembar Tiket)</label>
                    <input type="number" name="quota" required min="1" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-lg font-bold shadow transition">
                    Simpan Tiket
                </button>
            </form>
        </div>

        <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 shadow-lg lg:col-span-2 overflow-hidden">
            <h5 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2"> Daftar Tiket Tersedia</h5>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-300 text-sm border-b border-slate-700">
                            <th class="p-3 font-semibold">Jenis Tiket</th>
                            <th class="p-3 font-semibold text-right">Harga</th>
                            <th class="p-3 font-semibold text-center">Kuota</th>
                            <th class="p-3 font-semibold text-center">Terjual</th>
                            <th class="p-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700 text-slate-300 text-sm">
                        @forelse($event->ticketTypes as $ticket)
                        <tr class="hover:bg-slate-700/20 transition">
                            <td class="p-3 font-bold text-white">{{ $ticket->type_name }}</td>
                            <td class="p-3 text-right text-emerald-400 font-semibold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                            <td class="p-3 text-center">{{ $ticket->quota }}</td>
                            <td class="p-3 text-center">{{ $ticket->sold_quantity }}</td>
                           <td class="p-3 text-center flex justify-center items-center gap-3">
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition">
                                Edit
                            </a>
                            <span class="text-slate-600">|</span>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Hapus jenis tiket ini?');" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 font-medium transition">Hapus</button>
                            </form>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-500 italic">Belum ada jenis tiket. Silakan buat di form sebelah kiri.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
