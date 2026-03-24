@extends('layouts.master')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <h2 class="text-3xl font-black text-white mb-6">Checkout Tiket</h2>

    @if(session('error'))
        <div class="bg-red-500/20 text-red-400 border border-red-500/50 p-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg p-8">
        <div class="border-b border-slate-700 pb-6 mb-6">
            <h3 class="text-xl font-bold text-white">{{ $ticket->event->title }}</h3>
            <p class="text-slate-400 mt-1">Jenis Tiket: <span class="text-indigo-400 font-semibold">{{ $ticket->type_name }}</span></p>
            <p class="text-slate-400 mt-1">Harga per tiket: <span class="text-emerald-400 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span></p>
            <p class="text-slate-500 text-sm mt-1">Sisa Kuota: {{ $ticket->quota - $ticket->sold_quantity }} lembar</p>
        </div>

        <form action="{{ route('checkout.store', $ticket->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Jumlah Tiket yang Dibeli</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $ticket->quota - $ticket->sold_quantity }}" required
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white outline-none focus:border-indigo-500">
            </div>

            <div class="bg-slate-900 p-6 rounded-xl border border-slate-700">
                <p class="text-slate-400 font-medium">Total Pembayaran:</p>
                <h2 class="text-3xl font-black text-amber-400 mt-2" id="totalPrice">Rp {{ number_format($ticket->price, 0, ',', '.') }}</h2>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-xl transition shadow-lg text-lg">
                Proses Pesanan Sekarang
            </button>
        </form>
    </div>
</div>

<script>
    const price = {{ $ticket->price }};
    const qtyInput = document.getElementById('quantity');
    const totalElement = document.getElementById('totalPrice');

    qtyInput.addEventListener('input', function() {
        const qty = this.value || 0;
        const total = price * qty;
        totalElement.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    });
</script>
@endsection
