<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class="text-gray-700">Halo, <strong>{{ Auth::user()->name }}</strong>. Berikut ringkasan pengajuan adopsi Anda.</p>

        <div class="mt-4 grid gap-4 sm:grid-cols-4">
            @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dibatalkan' => 'Dibatalkan'] as $kunci => $label)
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="text-3xl font-bold text-indigo-600">{{ $ringkasan[$kunci] ?? 0 }}</div>
                    <div class="text-sm text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-lg bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Pengajuan terakhir</h3>
                <a href="{{ route('adopsi.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <ul class="mt-4 divide-y">
                @forelse ($terakhir as $a)
                    <li class="flex items-center justify-between py-3 text-sm">
                        <a href="{{ route('hewan.show', $a->hewan) }}" class="font-medium text-gray-800 hover:underline">{{ $a->hewan->nama }}</a>
                        <x-badge :status="$a->status" />
                    </li>
                @empty
                    <li class="py-3 text-sm text-gray-500">Belum ada pengajuan. <a href="{{ route('hewan.index') }}" class="text-indigo-600 hover:underline">Cari hewan untuk diadopsi</a>.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
