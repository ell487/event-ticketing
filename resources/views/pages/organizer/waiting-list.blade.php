@extends('layouts.master')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Tunggu</h1>

@if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-slate-800 rounded-lg overflow-hidden border border-slate-700">
    <table class="w-full text-left">
        <thead class="bg-slate-700 text-slate-300 text-sm">
            <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama User</th>
                <th class="px-4 py-3">Event</th>
                <th class="px-4 py-3">Tanggal Daftar</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi Organizer</th>
            </tr>
        </thead>
        <tbody class="text-slate-200">
            @forelse($waitingLists as $index => $item)
                <tr class="border-t border-slate-700">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-bold">{{ $item->user->name }}</td>
                    <td class="px-4 py-3">{{ $item->event->title }}</td>
                    <td class="px-4 py-3">{{ $item->created_at->format('d M Y, H:i') }}</td>

                    <td class="px-4 py-3 text-center">
                        @if($item->status === 'waiting')
                            <span class="bg-yellow-500/20 text-yellow-500 px-2 py-1 rounded text-xs font-bold">MENUNGGU</span>
                        @elseif($item->status === 'notified')
                            <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded text-xs font-bold">SUDAH DI-EMAIL</span>
                        @else
                            <span class="bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded text-xs font-bold">SELESAI BELI</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($item->status === 'waiting')
                            <form action="{{ route('organizer.waiting-list.notify', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm shadow transition">
                                    Kirim Email
                                </button>
                            </form>
                        @else
                            <span class="text-slate-500 text-sm">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-slate-400">
                        Belum ada yang ngantri buat event ini Boss.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
