@extends('layouts.master') @section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-white mb-2">Event Saya</h2>
    <p class="text-slate-400">Daftar event yang sedang atau pernah kamu selenggarakan.</p>
</div>

<div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-900/80 border-b border-slate-700 text-sm text-slate-400">
                    <th class="p-4 font-semibold uppercase tracking-wider">No</th>
                    <th class="p-4 font-semibold uppercase tracking-wider">Nama Event</th>
                    <th class="p-4 font-semibold uppercase tracking-wider">Tanggal</th>
                    <th class="p-4 font-semibold uppercase tracking-wider">Lokasi</th>
                    <th class="p-4 font-semibold uppercase tracking-wider">Status</th>
                    <th class="p-4 font-semibold uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-300">
                @forelse($events as $index => $event)
                <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition">
                    <td class="p-4">{{ $index + 1 }}</td>

                    <td class="p-4 font-medium text-white">{{ $event->title }}</td>

                    <td class="p-4">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>

                    <td class="p-4 truncate max-w-xs">{{ $event->location }}</td>

                    <td class="p-4">
                        <span class="px-2 py-1 bg-indigo-500/20 text-indigo-400 text-xs font-semibold rounded-md uppercase">
                            {{ $event->status }}
                        </span>
                    </td>

                    <td class="p-4 text-center">
                        <a href="{{ route('organizer.events.monitor',$event->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                            Pantau Penjualan
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-500 italic">
                        Belum ada event yang kamu tangani saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
