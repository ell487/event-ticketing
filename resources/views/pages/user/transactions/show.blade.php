@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-black text-white">E-Ticket Saya</h2>
        <a href="{{ route('user.tickets.index') }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-amber-500/10 border border-amber-500/30 p-4 rounded-xl flex items-start gap-3 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <div>
            <h4 class="text-amber-400 font-bold">Rahasiakan QR Code Anda!</h4>
            <p class="text-slate-400 text-sm mt-1">Jangan membagikan tangkapan layar (screenshot) halaman ini ke media sosial. QR Code ini bersifat rahasia dan hanya berlaku untuk 1 kali scan di pintu masuk event.</p>
        </div>
    </div>

    @foreach($transaction->details as $detail)
        @foreach($detail->tickets as $ticket)
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row mb-8 relative">

                <div class="hidden md:block absolute top-1/2 -translate-y-1/2 -left-4 w-8 h-8 bg-slate-900 rounded-full z-20"></div>
                <div class="hidden md:block absolute top-1/2 -translate-y-1/2 -right-4 w-8 h-8 bg-slate-900 rounded-full z-20"></div>

                <div class="bg-indigo-600 p-6 md:p-8 md:w-2/3 flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -top-16 -right-16 w-48 h-48 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-white/10 rounded-full"></div>

                    <div class="relative z-10 text-white">
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-indigo-800/60 text-indigo-100 text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block border border-indigo-500/30">
                                 Tipe: {{ $detail->ticket->type_name }}
                            </span>
                            <span class="text-indigo-200 font-mono text-sm opacity-80">{{ $transaction->invoice_code }}</span>
                        </div>

                        <h3 class="text-3xl font-black mb-2 leading-tight">{{ $transaction->event->title }}</h3>

                        <div class="space-y-3 mt-6 text-indigo-100">
                            <p class="flex items-start gap-3">
                                <span class="text-xl"></span>
                                <span>
                                    <strong class="block text-white">Waktu Pelaksanaan</strong>
                                    <span class="text-indigo-200">{{ \Carbon\Carbon::parse($transaction->event->created_at)->addDays(14)->format('d F Y, H:i') }} WIB</span>
                                </span>
                            </p>
                            <p class="flex items-start gap-3">
                                <span class="text-xl"></span>
                                <span>
                                    <strong class="block text-white">Lokasi</strong>
                                    <span class="text-indigo-200">Venue Event (Cek detail event)</span>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-indigo-500/50 relative z-10 flex justify-between items-end">
                        <div>
                            <p class="text-indigo-300 text-xs uppercase tracking-wider mb-1">Nama Pemesan</p>
                            <p class="font-bold text-white text-lg">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-indigo-300 text-xs uppercase tracking-wider mb-1">Status</p>
                            <p class="font-black text-emerald-400">LUNAS</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 md:p-8 md:w-1/3 flex flex-col items-center justify-center border-t-2 md:border-t-0 md:border-l-2 border-dashed border-slate-300 relative">
                    <div class="hidden md:block absolute -top-4 -left-4 w-8 h-8 bg-slate-900 rounded-full"></div>
                    <div class="hidden md:block absolute -bottom-4 -left-4 w-8 h-8 bg-slate-900 rounded-full"></div>

                    <div class="bg-white p-3 border border-slate-200 rounded-xl shadow-sm mb-4">
                        <img src="{{ asset('storage/' . $ticket->qr_code_path) }}" alt="QR Code {{ $ticket->ticket_code }}" class="w-40 h-40 object-contain">
                    </div>

                    <div class="text-center w-full">
                        <p class="text-slate-400 text-xs uppercase tracking-[0.2em] mb-1 font-semibold">Kode Tiket</p>
                        <div class="bg-slate-100 py-2 px-4 rounded-lg border border-slate-200">
                            <p class="font-mono font-black text-xl text-slate-800 tracking-wider">{{ $ticket->ticket_code }}</p>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @endforeach

</div>
@endsection
