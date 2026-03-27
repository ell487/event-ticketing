@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-3xl font-black text-white"> Kelola Kategori</h2>

        <button onclick="openModal('modal-add')" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-xl mb-6 font-medium">
             {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/20 text-red-400 border border-red-500/50 p-4 rounded-xl mb-6 font-medium">
             {{ session('error') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-slate-900/50 text-slate-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-center w-16">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Kategori</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-white">{{ $category->category_name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-400">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-4 flex justify-center gap-2">
                            <button onclick="openModal('modal-edit-{{ $category->id }}')" class="bg-amber-500/20 text-amber-400 hover:bg-amber-500 hover:text-white p-2 rounded-lg transition border border-amber-500/30 hover:border-amber-500" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                            </button>
                            <button onclick="openModal('modal-delete-{{ $category->id }}')" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white p-2 rounded-lg transition border border-red-500/30 hover:border-red-500" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            </button>
                        </td>
                    </tr>

                    <div id="modal-edit-{{ $category->id }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex justify-center items-center px-4">
                        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 w-full max-w-md shadow-2xl">
                            <h3 class="text-xl font-bold text-white mb-4"> Edit Kategori</h3>
                            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Kategori</label>
                                    <input type="text" name="category_name" value="{{ $category->category_name }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                                    <textarea name="description" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none">{{ $category->description }}</textarea>
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('modal-edit-{{ $category->id }}')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-slate-700 transition">Batal</button>
                                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-4 py-2 rounded-xl shadow transition">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                   <div id="modal-delete-{{ $category->id }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex justify-center items-center px-4">
                        <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700 w-full max-w-sm shadow-2xl text-center">

                            <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-white mb-3">Hapus Kategori?</h3>
                            <p class="text-slate-400 mb-8 leading-relaxed">
                                Yakin ingin menghapus <b class="text-white">{{ $category->category_name }}</b>? Tindakan ini tidak bisa dibatalkan.
                            </p>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="flex justify-center gap-4">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="closeModal('modal-delete-{{ $category->id }}')" class="px-5 py-3 rounded-xl text-slate-300 bg-slate-700/50 hover:bg-slate-700 transition w-full font-semibold">
                                    Batal
                                </button>
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-5 py-3 rounded-xl shadow-lg shadow-red-500/20 transition w-full">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada kategori. Klik "Tambah Kategori" untuk memulai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-add" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex justify-center items-center px-4">
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 w-full max-w-md shadow-2xl relative">
        <button type="button" onclick="closeModal('modal-add')" class="absolute top-4 right-4 text-slate-400 hover:text-white">✖</button>
        <h3 class="text-xl font-bold text-white mb-4"> Tambah Kategori Baru</h3>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Kategori</label>
                <input type="text" name="category_name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none" placeholder="Contoh: Konser Musik, Seminar, dll">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none" placeholder="Penjelasan singkat..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-add')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-slate-700 transition">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-4 py-2 rounded-xl shadow transition">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalID) {
        document.getElementById(modalID).classList.remove('hidden');
    }
    function closeModal(modalID) {
        document.getElementById(modalID).classList.add('hidden');
    }
</script>
@endsection
