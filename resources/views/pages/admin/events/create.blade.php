@extends('layouts.master')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h3 class="text-3xl font-bold text-white"> Buat Event Baru</h3>
            <p class="text-slate-400 mt-1">Lengkapi detail event yang akan kamu selenggarakan.</p>
        </div>

        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-sm font-medium rounded-lg border border-slate-700 transition-all duration-200 shadow-sm group w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400 group-hover:text-white group-hover:-translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-slate-800 rounded-xl border border-slate-700 p-8 shadow-lg">
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
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Event</label>
                    <input type="text" name="title" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Jakarta Music Fest">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                    <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tugaskan ke Organizer</label>
                    <select name="organizer_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Pilih Organizer --</option>
                        @foreach($organizers as $org)
                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jadwal Event (Tanggal & Waktu)</label>
                    <input type="datetime-local" name="date" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Lokasi Lengkap</label>
                    <input type="text" name="location" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: GBK Senayan, Jakarta">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Upload Banner Event (JPG/PNG)</label>
                    <input type="file" name="banner" required accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 transition cursor-pointer">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Event</label>
                <textarea name="description" rows="4" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Ceritakan detail menarik tentang event ini..."></textarea>
            </div>

            <div class="pt-4 border-t border-slate-700 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-lg font-bold shadow-lg transition transform hover:scale-105">
                    Simpan Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
