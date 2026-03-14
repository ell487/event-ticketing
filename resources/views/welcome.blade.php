<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FESTIX - Platform Ticketing & Event Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-200 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <nav class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-md fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-3xl font-black text-white tracking-widest">FES<span class="text-indigo-500">TIX</span></span>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2.5 rounded-lg transition shadow-lg shadow-indigo-500/30">
                                Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2.5 rounded-lg transition shadow-lg shadow-indigo-500/30">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-16 sm:pt-40 sm:pb-24 lg:pb-48 px-4 mx-auto max-w-7xl text-center">
        <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight mb-6">
            Beli Tiket Lebih Mudah, <br class="hidden sm:block">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">Akses Event Tanpa Ribet!</span>
        </h1>
        <p class="mt-4 text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10">
            FESTIX adalah platform ticketing terpercaya. Pilih tiket VIP atau Regular, lakukan pembayaran, dan dapatkan <strong>E-Ticket (QR Code)</strong> langsung ke emailmu!
        </p>
        <div class="flex justify-center">
            <a href="#events" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-10 rounded-full shadow-lg shadow-indigo-500/30 transition transform hover:scale-105">
                Cari Event Sekarang &rarr;
            </a>
        </div>
    </main>

    <section id="events" class="py-16 bg-slate-800/50 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-8">🔥 Event Mendatang</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 hover:border-indigo-500 transition group">
                    <div class="h-48 bg-slate-800 flex items-center justify-center text-5xl group-hover:scale-110 transition duration-500">🎸</div>
                    <div class="p-6">
                        <div class="text-indigo-400 text-sm font-semibold mb-2">12 Agustus 2026</div>
                        <h3 class="text-xl font-bold text-white mb-2">Jakarta Music Fest</h3>
                        <p class="text-slate-400 text-sm mb-4">GBK Senayan, Jakarta</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded">VIP Tersedia</span>
                            <span class="text-xs bg-slate-700 text-slate-300 px-2 py-1 rounded">Regular Tersedia</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-700 pt-4">
                            <span class="text-lg font-bold text-white">Rp 350.000</span>
                            <button class="text-indigo-400 hover:text-white font-semibold">Beli Tiket &rarr;</button>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 hover:border-indigo-500 transition group">
                    <div class="h-48 bg-slate-800 flex items-center justify-center text-5xl group-hover:scale-110 transition duration-500">💻</div>
                    <div class="p-6">
                        <div class="text-indigo-400 text-sm font-semibold mb-2">5 Oktober 2026</div>
                        <h3 class="text-xl font-bold text-white mb-2">Tech Startup Summit</h3>
                        <p class="text-slate-400 text-sm mb-4">ICE BSD, Tangerang</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs bg-slate-700 text-slate-300 px-2 py-1 rounded">Regular Tersedia</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-700 pt-4">
                            <span class="text-lg font-bold text-white">Gratis</span>
                            <button class="text-indigo-400 hover:text-white font-semibold">Daftar &rarr;</button>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 hover:border-indigo-500 transition group">
                    <div class="h-48 bg-slate-800 flex items-center justify-center text-5xl group-hover:scale-110 transition duration-500">🎭</div>
                    <div class="p-6">
                        <div class="text-indigo-400 text-sm font-semibold mb-2">20 September 2026</div>
                        <h3 class="text-xl font-bold text-white mb-2">Standup Comedy Tour</h3>
                        <p class="text-slate-400 text-sm mb-4">Sabuga, Bandung</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded">VIP (Habis)</span>
                            <span class="text-xs bg-slate-700 text-slate-300 px-2 py-1 rounded">Regular Tersedia</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-700 pt-4">
                            <span class="text-lg font-bold text-white">Rp 150.000</span>
                            <button class="text-indigo-400 hover:text-white font-semibold">Beli Tiket &rarr;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-8 text-center border-t border-slate-800 text-slate-500">
        <p>&copy; 2026 FESTIX - Platform Ticketing & Event Management. All rights reserved.</p>
    </footer>

</body>
</html>
