@extends('layouts.master')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg p-8">
        <h2 class="text-2xl font-black text-white mb-6 text-center border-b border-slate-700 pb-4">💳 Selesaikan Pembayaran</h2>

        <div class="space-y-4 mb-8">
            <div class="flex justify-between items-center bg-slate-900 p-4 rounded-xl border border-slate-700">
                <span class="text-slate-400">Nomor Invoice</span>
                <span class="font-mono text-indigo-400 font-bold">{{ $transaction->invoice_code }}</span>
            </div>

            <div class="flex justify-between items-center bg-slate-900 p-4 rounded-xl border border-slate-700">
                <span class="text-slate-400">Event</span>
                <span class="text-white font-medium text-right">{{ $transaction->event->title }}</span>
            </div>

            @php $totalAmount = 0; @endphp
            @foreach($transaction->details as $detail)
                @php $totalAmount += ($detail->quantity * $detail->ticket->price); @endphp
                <div class="flex justify-between items-center bg-slate-900 p-4 rounded-xl border border-slate-700">
                    <div>
                        <span class="text-white block">{{ $detail->ticket->type_name }}</span>
                        <span class="text-slate-500 text-sm">{{ $detail->quantity }}x Rp {{ number_format($detail->ticket->price, 0, ',', '.') }}</span>
                    </div>
                    <span class="text-white font-medium">Rp {{ number_format($detail->quantity * $detail->ticket->price, 0, ',', '.') }}</span>
                </div>
            @endforeach

            <div class="flex justify-between items-center bg-indigo-500/10 p-4 rounded-xl border border-indigo-500/30 mt-4">
                <span class="text-indigo-300 font-bold">TOTAL TAGIHAN</span>
                <span class="text-3xl font-black text-emerald-400">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- PERHATIKAN: enctype="multipart/form-data" ini WAJIB ada buat upload file --}}
        <form action="{{ route('payment.process', $transaction->invoice_code) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-300 mb-2">Pilih Metode Pembayaran</label>
                <select name="payment_channel" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white outline-none focus:border-indigo-500">
                    <option value="BCA">BCA Virtual Account</option>
                    <option value="MANDIRI">Mandiri Virtual Account</option>
                    <option value="GOPAY">GoPay</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

           {{-- input file bukti pembayaran --}}
            <div class="mb-8">
                <label class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                <input type="file" name="payment_proof" accept="image/png, image/jpeg, image/jpg" required
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white outline-none focus:border-indigo-500
                           file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer transition">
                <p class="text-xs text-slate-500 mt-2">Format yang diizinkan: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>


                @error('payment_proof')
                    <p class="text-red-400 text-xs mt-2 bg-red-500/10 p-2 rounded border border-red-500/20">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl transition shadow-lg text-lg flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
