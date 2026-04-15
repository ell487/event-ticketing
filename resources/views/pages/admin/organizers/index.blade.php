@extends('layouts.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-3xl font-black text-white"> Kelola Organizer</h2>

        <button onclick="openModal('modal-add')" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Tambah Organizer
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
                        <th class="px-6 py-4 font-semibold">Nama Organizer</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold text-center">Tanggal Gabung</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($organizers as $index => $organizer)
                    <tr class="hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-white">{{ $organizer->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-400">{{ $organizer->email }}</td>
                        <td class="px-6 py-4 text-center text-sm text-slate-400">{{ $organizer->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-emerald-500/10 text-emerald-500 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-500/20">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada organizer. Klik "Tambah Organizer" untuk memulai.</td>
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
        <h3 class="text-xl font-bold text-white mb-4"> Tambah Organizer Baru</h3>

        <form action="{{ route('admin.organizers.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none" placeholder="Masukkan nama organizer">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                <input type="email" name="email" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none" placeholder="email@contoh.com">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-300 mb-2">Password Sementara</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-indigo-500 outline-none" placeholder="Minimal 8 karakter">
                <p class="text-[11px] text-slate-500 mt-2 italic">*Berikan password ini agar organizer bisa login.</p>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-add')" class="px-4 py-2 rounded-xl text-slate-300 hover:bg-slate-700 transition">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-4 py-2 rounded-xl shadow transition">Simpan Organizer</button>
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
