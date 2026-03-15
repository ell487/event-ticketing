<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Route Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 2. Group Route KHUSUS ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('events', EventController::class);
});

// 3. Group Route KHUSUS ORGANIZER
Route::middleware(['auth', 'role:organizer'])->group(function () {
    // Nanti fitur Dashboard Analitik & Export Excel ditaruh di sini
});

// 4. Group Route KHUSUS USER BIASA
Route::middleware(['auth', 'role:user'])->group(function () {
    // Nanti route beli tiket dan lihat e-ticket taruh di sini
});

// 5.Rute untuk melihat Detail Event (tempat admin nambahin tiket)
Route::get('/events/{id}/show', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');

// Rute untuk menyimpan & menghapus Jenis Tiket
Route::post('/events/{id}/tickets', [App\Http\Controllers\TicketTypeController::class, 'store'])->name('tickets.store');
Route::delete('/tickets/{id}', [App\Http\Controllers\TicketTypeController::class, 'destroy'])->name('tickets.destroy');

// Route Profile (
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
