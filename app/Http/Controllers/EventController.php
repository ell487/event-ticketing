<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class EventController extends Controller
{


    // 1. Menampilkan Daftar Semua Event
    public function index()
    {

        $events = Event::all();

        // Kirim datanya ke file view 'index.blade.php'
        return view('pages.admin.events.index', compact('events'));
    }


    // 2. Menampilkan Form Tambah Event
    public function create()
    {
      // Ambil data kategori dari database
        $categories = DB::table('categories')->get();

        // Ambil hanya user yang punya role 'organizer'
        $organizers = User::where('role', 'organizer')->get();

        // Kirim datanya ke view
        return view('pages.admin.events.create', compact('categories', 'organizers'));
    }

    // 3. Menampilkan Form Edit (Update - Bagian 1)
    public function edit($id)
    {
        $event = Event::findOrFail($id); // Cari event berdasarkan ID
        $categories = DB::table('categories')->get();
        $organizers = User::where('role', 'organizer')->get();

        return view('pages.admin.events.edit', compact('event', 'categories', 'organizers'));
    }

    // 4. Menyimpan Perubahan Edit (Update - Bagian 2)
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validasi (Perhatikan: banner sekarang nullable/tidak wajib diisi jika tidak ingin diganti)
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // atau kategori_id sesuai primary key kamu
            'organizer_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'location' => 'required|string',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $bannerPath = $event->banner_path; // Default pakai gambar lama

        // Cek jika admin upload banner baru
        if ($request->hasFile('banner')) {
            // Hapus gambar lama dari storage jika ada
            if ($event->banner_path) {
                Storage::disk('public')->delete($event->banner_path);
            }
            // Simpan gambar baru
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }



        // Update ke Database
        $event->update([
            'organizer_id' => $request->organizer_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'banner_path' => $bannerPath,
            'location' => $request->location,
            'event_date' => $request->date,
        ]);

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui!');
    }

    // 5. Menghapus Data (Delete)
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Hapus gambar fisik dari folder storage agar tidak menumpuk jadi sampah
        if ($event->banner_path) {
            Storage::disk('public')->delete($event->banner_path);
        }

        // Hapus data dari database
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }

    // 6.Menampilkan Detail Event & Mengelola Tiket
    public function show($id)
    {
        // Ambil data event sekaligus narik data tiket-tiketnya
        $event = Event::with('ticketTypes')->findOrFail($id);

        return view('pages.admin.events.show', compact('event'));
    }

    // 7. Menyimpan Data Event
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi id kategori
            'organizer_id' => 'required|exists:users,id',     // Validasi id organizer
            'date' => 'required|date',
            'location' => 'required|string',
            'description' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        // Upload Banner
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        // Simpan ke Database (SEKARANG TANPA HARDCODE!)
        Event::create([
            'organizer_id' => $request->organizer_id, // Mengambil pilihan dari form
            'category_id' => $request->category_id,   // Mengambil pilihan dari form
            'title' => $request->title,
            'description' => $request->description,
            'banner_path' => $bannerPath,
            'location' => $request->location,
            'event_date' => $request->date,
            'status' => 'published',
        ]);





        return redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }
}
