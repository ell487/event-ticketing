<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TIXEVENT - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-200 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-slate-700">
            <h1 class="text-2xl font-black text-white tracking-wider">
                TIX<span class="text-indigo-500">EVENT</span>
            </h1>
        </div>

       <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-2">
            <a href="/dashboard" class="block px-4 py-2.5 rounded-lg {{ request()->is('dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'hover:bg-slate-700 text-slate-300 transition' }}">
                 Dashboard
            </a>

            @if(Auth::user()->role === 'admin')
            <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-slate-700 text-slate-300 transition">
                Kelola Kategori
            </a>
            <a href="{{ route('events.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('events.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'hover:bg-slate-700 text-slate-300 transition' }}">
                Kelola Event
            </a>
            <a href="{{ route('admin.reports.index`') }}" class="block px-4 py-2.5 rounded-lg hover:bg-slate-700 text-slate-300 transition">
                Laporan Transaksi
            </a>
            @endif

            @if(Auth::user()->role === 'organizer')
            <a href="{{ route('organizer.events.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('events.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'hover:bg-slate-700 text-slate-300 transition' }}">
                Event Saya
            </a>
            <a href="{{ route('organizer.reports') }}" class="block px-4 py-2.5 rounded-lg hover:bg-slate-700 text-slate-300 transition">
                Laporan Penjualan
            </a>
            @endif

            @if(Auth::user()->role === 'user')
            <a href="{{ route('user.tickets.index') }}" class="block px-4 py-2.5 rounded-lg hover:bg-slate-700 text-slate-300 transition">
                Tiket Saya
            </a>
            <a href="{{ route('user.events.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('user.events.index') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'hover:bg-slate-700 text-slate-300 transition' }}">
                Cari Event
            </a>
            @endif
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-6">
            <h2 class="text-lg font-semibold text-slate-200 capitalize">
                Panel {{ Auth::user()->role }}
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-400 font-medium">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-md font-semibold transition">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900 p-6">
            @yield('content')
        </main>
    </div>

    <script src="..."></script>

    @stack('scripts')
</body>
</html>
