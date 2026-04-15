<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    // 1. Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->get();
        return view('pages.admin.categories.index', compact('categories'));
    }

    // 2. Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 3. Mengupdate kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
            'description' => $request->description
        ]);

        return back()->with('success', 'Kategori berhasil diubah!');
    }

    // 4. Menghapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);


        if($category->events()->count() > 0) {
            return back()->with('error', 'Gagal dihapus! Kategori ini sedang digunakan oleh event.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    // Fitur Kelola Organizer

    // 1. Menampilkan daftar organizer
    public function organizerIndex()
    {
        // Mengambil user yang punya role 'organizer'
        $organizers = User::where('role', 'organizer')->latest()->get();
        return view('pages.admin.organizers.index', compact('organizers'));
    }

    // 2. Menyimpan Organizer baru
    public function organizerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash biar aman
            'role' => 'organizer', // Langsung set sebagai organizer
        ]);

        return back()->with('success', 'Akun Organizer berhasil ditambahkan!');
    }
}


