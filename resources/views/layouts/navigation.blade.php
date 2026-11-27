<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-[#e7e9e1] bg-[#fbfaf7]/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="flex h-[4.5rem] items-center justify-between">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="PetHaven, beranda">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#365b45] text-white"><x-paw-mark class="h-6 w-6" /></span>
                <span class="font-serif text-2xl font-semibold tracking-tight text-[#2d4937]">{{ config('app.name', 'PetHaven') }}</span>
            </a>

            <div class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Beranda</a>
                <a href="{{ route('hewan.index') }}" class="text-sm font-semibold {{ request()->routeIs('hewan.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Cari sahabat</a>
                @auth
                    @can('kelola hewan')
                        <a href="{{ route('admin.hewan.index') }}" class="text-sm font-semibold text-[#778176] hover:text-[#365b45]">Kelola hewan</a>
                    @endcan
                    @can('kelola kategori')
                        <a href="{{ route('admin.kategori.index') }}" class="text-sm font-semibold text-[#778176] hover:text-[#365b45]">Kategori</a>
                    @endcan
                    @can('kelola pengajuan adopsi')
                        <a href="{{ route('admin.adopsi.index') }}" class="text-sm font-semibold text-[#778176] hover:text-[#365b45]">Pengajuan</a>
                        <a href="{{ route('admin.laporan.index') }}" class="text-sm font-semibold {{ request()->routeIs('admin.laporan.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Laporan</a>
                    @endcan
                    @can('kelola pesan pelanggan')
                        <a href="{{ route('admin.chat.index') }}" class="text-sm font-semibold {{ request()->routeIs('admin.chat.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Pesan Pelanggan</a>
                    @endcan
                    @can('kelola pengguna')
                        <a href="{{ route('admin.pengguna.index') }}" class="text-sm font-semibold text-[#778176] hover:text-[#365b45]">Pengguna</a>
                    @endcan
                    @can('melihat riwayat adopsi sendiri')
                        <a href="{{ route('adopsi.index') }}" class="text-sm font-semibold {{ request()->routeIs('adopsi.index') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Riwayat</a>
                        <a href="{{ route('chat.index') }}" class="text-sm font-semibold {{ request()->routeIs('chat.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Chat Admin</a>
                    @endcan
                    <a href="{{ route('syarat-ketentuan.show') }}" class="text-sm font-semibold {{ request()->routeIs('syarat-ketentuan.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Syarat &amp; Ketentuan</a>
                @endauth
                @guest
                    <a href="{{ route('syarat-ketentuan.show') }}" class="text-sm font-semibold {{ request()->routeIs('syarat-ketentuan.*') ? 'text-[#365b45]' : 'text-[#778176] hover:text-[#365b45]' }}">Syarat &amp; Ketentuan</a>
                @endguest
            </div>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-xl border border-[#e3e7df] bg-white px-4 py-2.5 text-sm font-semibold text-[#405447] transition hover:border-[#b8c9b6] focus:outline-none focus:ring-2 focus:ring-[#52735c]">
                                <span class="grid h-6 w-6 place-items-center rounded-full bg-[#edf3e9] text-xs text-[#365b45]">{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}</span>
                                <span class="max-w-28 truncate">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-[#899389]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">Dashboard</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-[#607065] transition hover:text-[#2f4d3a]">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#365b45] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#294936] focus:outline-none focus:ring-2 focus:ring-[#365b45] focus:ring-offset-2">Mulai adopsi</a>
                @endauth
            </div>

            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-menu" class="grid h-10 w-10 place-items-center rounded-xl border border-[#e3e7df] text-[#365b45] md:hidden">
                <span class="sr-only">Buka menu</span>
                <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" x-show="open" x-cloak x-transition class="border-t border-[#e7e9e1] bg-[#fbfaf7] px-5 pb-5 pt-3 md:hidden">
        <div class="space-y-1">
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#365b45]">Beranda</a>
            <a href="{{ route('hewan.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Cari sahabat</a>
            @auth
                @can('kelola hewan')
                    <a href="{{ route('admin.hewan.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Kelola hewan</a>
                @endcan
                @can('kelola kategori')
                    <a href="{{ route('admin.kategori.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Kategori</a>
                @endcan
                @can('kelola pengajuan adopsi')
                    <a href="{{ route('admin.adopsi.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Pengajuan</a>
                    <a href="{{ route('admin.laporan.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Laporan</a>
                @endcan
                @can('kelola pesan pelanggan')
                    <a href="{{ route('admin.chat.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Pesan Pelanggan</a>
                @endcan
                @can('kelola pengguna')
                    <a href="{{ route('admin.pengguna.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Pengguna</a>
                @endcan
                @can('melihat riwayat adopsi sendiri')
                    <a href="{{ route('adopsi.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Riwayat</a>
                    <a href="{{ route('chat.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Chat Admin</a>
                @endcan
                <a href="{{ route('syarat-ketentuan.show') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Syarat &amp; Ketentuan</a>
                <div class="mt-3 border-t border-[#e7e9e1] pt-3">
                    <p class="px-3 text-sm font-semibold text-[#33483a]">{{ Auth::user()->name }}</p>
                    <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2.5 text-sm text-[#68766b] hover:bg-[#f0f3ed]">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2.5 text-sm text-[#68766b] hover:bg-[#f0f3ed]">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm text-[#68766b] hover:bg-[#f0f3ed]">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('syarat-ketentuan.show') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-[#68766b] hover:bg-[#f0f3ed]">Syarat &amp; Ketentuan</a>
                <div class="mt-3 grid grid-cols-2 gap-3 border-t border-[#e7e9e1] pt-4">
                    <a href="{{ route('login') }}" class="rounded-xl border border-[#dfe5dc] px-4 py-2.5 text-center text-sm font-semibold text-[#365b45]">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#365b45] px-4 py-2.5 text-center text-sm font-semibold text-white">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
