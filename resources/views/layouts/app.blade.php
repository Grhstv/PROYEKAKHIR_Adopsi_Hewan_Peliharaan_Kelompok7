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
                <div class="mx-auto grid max-w-7xl gap-6 px-5 py-7 text-sm text-[#788176] sm:px-8 md:grid-cols-[1fr_auto] md:items-center lg:px-10">
                    <div>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-[#365b45]"><x-paw-mark class="h-5 w-5" /> {{ config('app.name', 'PetHaven') }}</a>
                        <p class="mt-2">&copy; {{ date('Y') }} PetHaven. Setiap sahabat layak mendapat rumah yang penuh kasih.</p>
                    </div>
                    <div class="space-y-2 md:text-right">
                        <p class="font-semibold text-[#33483a]">Hubungi Admin</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-2 md:justify-end">
                            <a href="tel:{{ config('contact.admin_phone_e164') }}" class="font-medium text-[#52735c] hover:text-[#294936]">{{ config('contact.admin_phone_display') }}</a>
                            <a href="https://wa.me/{{ config('contact.admin_whatsapp') }}" target="_blank" rel="noopener noreferrer" class="font-medium text-[#52735c] hover:text-[#294936]">WhatsApp</a>
                            @auth
                                @can('melihat riwayat adopsi sendiri')
                                    <a href="{{ route('chat.index') }}" class="font-medium text-[#52735c] hover:text-[#294936]">Chat di web</a>
                                @endcan
                                @can('kelola pesan pelanggan')
                                    <a href="{{ route('admin.chat.index') }}" class="font-medium text-[#52735c] hover:text-[#294936]">Kotak pesan admin</a>
                                @endcan
                            @else
                                <a href="{{ route('login') }}" class="font-medium text-[#52735c] hover:text-[#294936]">Masuk untuk chat di web</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
