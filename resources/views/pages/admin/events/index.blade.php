@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-3xl font-bold text-white">Daftar Event</h3>
            <p class="text-slate-400 mt-1">Kelola semua event yang ada di sistem FESTIX.</p>
        </div>
        <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg transition">
            + Buat Event Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 text-slate-300 text-sm border-b border-slate-700">
                        <th class="p-4 font-semibold">Banner</th>
                        <th class="p-4 font-semibold">Nama Event</th>
                        <th class="p-4 font-semibold">Tanggal</th>
                        <th class="p-4 font-semibold">Lokasi</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700 text-slate-300 text-sm">
                    @forelse($events as $event)
                    <tr class="hover:bg-slate-700/20 transition">
                        <td class="p-4">
                            @if($event->banner_path)
                                <img src="{{ asset('storage/' . $event->banner_path) }}" alt="Banner" class="w-16 h-10 object-cover rounded border border-slate-600">
                            @else
                                <span class="text-slate-500 italic">No Image</span>
                            @endif
                        </td>

                        <td class="p-4 font-bold text-white">{{ $event->title }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</td>
                        <td class="p-4">{{ $event->location }}</td>
                        <td class="p-4">
                            <span class="bg-emerald-500/20 text-emerald-400 px-2.5 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('events.show', $event->id) }}" class="text-emerald-400 hover:text-emerald-300 font-medium transition mr-2">
                                    Tiket
                                </a>

                                <a href="{{ route('events.edit', $event->id) }}"
                                class="text-indigo-400 hover:text-indigo-300 font-medium transition">
                                    Edit
                                </a>

                                <form action="{{ route('events.destroy', $event->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus event ini? Data tidak bisa dikembalikan!');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-red-400 hover:text-red-300 font-medium transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500 italic">
                            Belum ada data event. Silakan buat event baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
