@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg mb-4" role="alert">
            <span class="font-medium">Mantap!</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-4" role="alert">
            <span class="font-medium">Oops!</span> {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('user.events.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-indigo-400 transition font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Event
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 shadow-lg">
                @if($event->banner_path)
                    <img src="{{ asset('storage/' . $event->banner_path) }}" class="w-full h-80 object-cover">
                @else
                    <div class="w-full h-80 flex items-center justify-center bg-slate-900 text-slate-600">Banner Tidak Tersedia</div>
                @endif

                <div class="p-8 space-y-4">
                    @if($event->category)
                        <span class="bg-indigo-500/20 text-indigo-400 px-3 py-1 rounded-full text-sm font-semibold border border-indigo-500/30">
                            {{ $event->category->category_name }}
                        </span>
                    @endif
                    <h1 class="text-3xl font-black text-white">{{ $event->title }}</h1>

                    <div class="flex flex-wrap gap-6 mt-4 pt-4 border-t border-slate-700">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="bg-slate-700 p-2 rounded-lg"></div>
                            <div>
                                <p class="text-xs text-slate-400">Tanggal & Waktu</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="bg-slate-700 p-2 rounded-lg"></div>
                            <div>
                                <p class="text-xs text-slate-400">Lokasi</p>
                                <p class="font-medium">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h3 class="text-xl font-bold text-white mb-2">Deskripsi Event</h3>
                        <p class="text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-2xl font-bold text-white">Pilih Tiket</h3>

         @forelse($event->ticketTypes as $ticket)
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 shadow-lg hover:border-indigo-500 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h4 class="text-xl font-bold text-white">{{ $ticket->type_name }}</h4>
                        @php $sisaKuota = $ticket->quota - $ticket->sold_quantity; @endphp
                        <p class="text-sm {{ $sisaKuota > 0 ? 'text-emerald-400' : 'text-red-400' }} font-medium mt-1">
                            Sisa Kuota: {{ $sisaKuota }} tiket
                        </p>
                    </div>
                </div>

                <p class="text-2xl font-black text-indigo-400 mb-6">
                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                </p>

               @php
                    $sudahNgantri = false;
                    if(auth()->check()){
                        $sudahNgantri = \App\Models\WaitingList::where('user_id', auth()->id())
                                            ->where('event_id', $event->id)
                                            ->exists();
                    }
                @endphp

                @if($sisaKuota > 0)
                    <a href="{{ route('checkout.index', $ticket->id) }}" class="btn btn-primary bg-indigo-500 text-white px-4 py-2 rounded w-full block text-center">
                        Beli Tiket
                    </a>
                @else
                    <div class="text-red-400 text-sm font-bold mb-3">
                        Yah, tiket jenis ini udah Sold Out!
                    </div>

                    @if($sudahNgantri)
                        <button disabled class="btn btn-secondary bg-slate-600 text-slate-300 px-4 py-2 rounded w-full font-bold cursor-not-allowed">
                            Lo Udah di Daftar Tunggu
                        </button>
                    @else
                        <form action="{{ route('waiting-list.store', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning bg-yellow-500 text-black px-4 py-2 rounded w-full font-bold hover:bg-yellow-400 transition">
                                Masuk Waiting List
                            </button>
                        </form>
                    @endif
                @endif
            </div>
            @empty
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 text-center shadow-lg">
                <p class="text-slate-400">Belum ada tiket yang tersedia untuk event ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
