@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-sm font-medium rounded-lg border border-slate-700 transition-all duration-200 shadow-sm group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 group-hover:text-white group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h3 class="text-3xl font-bold text-white"> Edit Event</h3>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/20 text-red-400 border border-red-500/50 p-4 rounded-lg mb-6">
            <div class="font-bold mb-2">Oops! Ada yang salah:</div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 md:p-8 shadow-lg">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Event</label>
                    <input type="text" name="title" value="{{ $event->title }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                    <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Organizer</label>
                    <select name="organizer_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none">
                        @foreach($organizers as $org)
                            <option value="{{ $org->id }}" {{ $event->organizer_id == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal & Waktu</label>
                    <input type="datetime-local" name="date" value="{{ $event->event_date }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Lokasi / Venue</label>
                    <input type="text" name="location" value="{{ $event->location }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Event</label>
                <textarea name="description" rows="4" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white outline-none">{{ $event->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Banner Event Baru (Opsional)</label>
                <input type="file" name="banner" accept="image/png, image/jpeg, image/jpg" class="w-full text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 transition cursor-pointer">
                <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>

                @if($event->banner_path)
                    <div class="mt-4">
                        <p class="text-sm text-slate-400 mb-2">Banner saat ini:</p>
                        <img src="{{ asset('storage/' . $event->banner_path) }}" class="h-32 rounded-lg border border-slate-700 object-cover">
                    </div>
                @endif
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-700 mt-6">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-lg font-bold shadow-lg transition transform hover:-translate-y-0.5">
                     Update Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
