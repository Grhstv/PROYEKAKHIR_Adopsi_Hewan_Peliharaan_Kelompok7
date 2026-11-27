<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="theme-color" content="#f7f6f1">
        <meta name="description" content="Temukan teman baru dan beri mereka rumah yang penuh kasih bersama PetHaven.">
        <title>{{ config('app.name', 'PetHaven') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|dm-serif-display:400&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#263a2f]">
        <div class="min-h-screen bg-[#f7f6f1]">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                <x-flash />
                {{ $slot }}
            </main>

            <footer class="border-t border-[#e5e8df] bg-white">
                <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-7 text-sm text-[#788176] sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-10">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-[#365b45]"><x-paw-mark class="h-5 w-5" /> {{ config('app.name', 'PetHaven') }}</a>
                    <p>&copy; {{ date('Y') }} PetHaven. Setiap sahabat layak mendapat rumah yang penuh kasih.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
