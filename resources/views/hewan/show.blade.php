<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ $hewan->nama }}</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="overflow-hidden rounded-lg bg-white shadow md:flex">
            <img src="{{ $hewan->foto_src }}" alt="Foto {{ $hewan->nama }}" class="h-72 w-full object-cover md:h-auto md:w-1/2">
            <div class="p-6 md:w-1/2">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $hewan->nama }}</h1>
                    <x-badge :status="$hewan->status" />
                </div>
                <p class="text-gray-500">{{ $hewan->kategori->nama }} &middot; {{ $hewan->ras ?? 'Campuran' }}</p>

                <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                    <div><dt class="text-gray-500">Jenis kelamin</dt><dd class="font-medium">{{ ucfirst($hewan->jenis_kelamin) }}</dd></div>
                    <div><dt class="text-gray-500">Umur</dt><dd class="font-medium">{{ $hewan->umur_label }}</dd></div>
                    <div><dt class="text-gray-500">Warna</dt><dd class="font-medium">{{ $hewan->warna ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Kesehatan</dt><dd class="font-medium">{{ $hewan->kesehatan ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Vaksin</dt><dd class="font-medium">{{ $hewan->sudah_vaksin ? 'Sudah' : 'Belum' }}</dd></div>
                    <div><dt class="text-gray-500">Steril</dt><dd class="font-medium">{{ $hewan->sudah_steril ? 'Sudah' : 'Belum' }}</dd></div>
                </dl>

                <p class="mt-4 whitespace-pre-line text-gray-700">{{ $hewan->deskripsi }}</p>

                <div class="mt-6">
                    @if ($hewan->status !== 'tersedia')
                        <p class="rounded-md bg-gray-100 p-3 text-sm text-gray-600">Hewan ini sudah menemukan rumah baru. 🎉</p>
                    @elseif (! auth()->check())
                        <a href="{{ route('login') }}" class="inline-block rounded-md bg-indigo-600 px-5 py-2.5 font-semibold text-white hover:bg-indigo-500">Masuk untuk mengadopsi</a>
                    @else
                        @can('mengajukan adopsi')
                            @if ($sudahMengajukan)
                                <p class="rounded-md bg-yellow-50 p-3 text-sm text-yellow-800">Pengajuan Anda untuk hewan ini sedang menunggu keputusan.</p>
                            @else
                                <a href="{{ route('adopsi.create', $hewan) }}" class="inline-block rounded-md bg-indigo-600 px-5 py-2.5 font-semibold text-white hover:bg-indigo-500">Ajukan Adopsi</a>
                            @endif
                        @endcan
                    @endif
                </div>
            </div>
        </div>

        @if ($serupa->isNotEmpty())
            <h2 class="mt-10 text-xl font-bold text-gray-800">Hewan {{ strtolower($hewan->kategori->nama) }} lainnya</h2>
            <div class="mt-4 grid gap-6 sm:grid-cols-3">
                @foreach ($serupa as $h)
                    @include('hewan._card', ['hewan' => $h])
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
