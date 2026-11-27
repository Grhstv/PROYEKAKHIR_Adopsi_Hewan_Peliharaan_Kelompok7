<nav aria-label="Informasi dan pengelolaan syarat ketentuan" class="border-b border-[#e7e9e1] bg-[#f1f4ec]">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-6 gap-y-2 px-5 py-3 text-sm sm:px-8 lg:px-10">
        <a href="{{ route('syarat-ketentuan.show') }}" class="font-semibold text-[#365b45] transition hover:text-[#294936]">
            Syarat &amp; Ketentuan
        </a>
        @auth
            @can('kelola syarat dan ketentuan')
                <a href="{{ route('admin.syarat-ketentuan.edit') }}" class="font-medium text-[#68766b] transition hover:text-[#365b45]">
                    Edit halaman
                </a>
            @endcan
            @can('lihat laporan')
                <a href="{{ route('admin.laporan.index') }}" class="font-medium text-[#68766b] transition hover:text-[#365b45]">
                    Laporan
                </a>
            @endcan
        @endauth
    </div>
</nav>
