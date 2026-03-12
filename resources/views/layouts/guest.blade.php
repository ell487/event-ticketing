<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-900 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white drop-shadow-lg">
                        FES<span class="text-indigo-500">TIX</span>
                    </h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-10 px-8 py-10 bg-slate-800 border border-slate-700 shadow-2xl shadow-indigo-900/20 overflow-hidden sm:rounded-2xl text-slate-300">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>