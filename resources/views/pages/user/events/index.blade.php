@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div>
        <h2 class="text-3xl font-black text-white tracking-wide"> Temukan Event Seru!</h2>
        <p class="text-slate-400 mt-2">Jelajahi berbagai event menarik dan amankan tiketmu sekarang juga.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($events as $event)
        <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg hover:shadow-indigo-500/20 hover:-translate-y-1 transition-all duration-300 group flex flex-col">

            <div class="relative h-48 overflow-hidden bg-slate-900">
                @if($event->banner_path)
                    <img src="{{ asset('storage/' . $event->banner_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-600">No Image</div>
                @endif

                @if($event->category)
                <div class="absolute top-4 left-4 bg-indigo-600/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                    {{ $event->category->category_name }}
                </div>
                @endif
            </div>

            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $event->title }}</h3>

                <div class="space-y-2 mt-auto mb-6">
                    <p class="text-slate-400 text-sm flex items-center gap-2">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}
                    </p>
                    <p class="text-slate-400 text-sm flex items-center gap-2 line-clamp-1">
                        {{ $event->location }}
                    </p>
                </div>

                <a href="{{ route('user.events.show', $event->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 rounded-xl transition shadow-md">
                    Lihat Tiket
                </a>
            </div>
        </div>
        @empty

        <div class="col-span-full bg-slate-800/50 border border-slate-700 border-dashed rounded-2xl p-12 text-center">
            <h3 class="text-xl font-bold text-slate-300 mb-2">Yah, belum ada event nih 😢</h3>
            <p class="text-slate-500">Tunggu admin nambahin event baru ya!</p>
        </div>

        @endforelse

    </div>
</div>
@endsection
