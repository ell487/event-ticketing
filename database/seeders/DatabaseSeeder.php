<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT DUMMY KATEGORI
        DB::table('categories')->insert([
            ['category_name' => 'Konser Musik', 'description' => 'Acara konser musik live'],
            ['category_name' => 'Standup Comedy', 'description' => 'Acara komedi tunggal'],
            ['category_name' => 'Workshop & Seminar', 'description' => 'Acara edukasi dan pelatihan'],
        ]);

        // 2. BUAT DUMMY USERS (Admin, Organizer, User)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@festix.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Organizer ',
            'email' => 'organizer@festix.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);

        User::create([
            'name' => 'Yanto',
            'email' => 'user@festix.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
