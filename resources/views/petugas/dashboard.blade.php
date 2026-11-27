<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Petugas Shelter</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <p class="mb-6 text-sm text-gray-600">Area petugas hanya untuk operasional hewan dan pengajuan adopsi.</p>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Hewan', $totalHewan],
                ['Tersedia', $totalTersedia],
                ['Teradopsi', $totalTeradopsi],
                ['Pengajuan menunggu', $totalMenunggu],
            ] as [$label, $value])
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="text-3xl font-bold text-indigo-600">{{ $value }}</div>
                    <div class="text-sm text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            <a href="{{ route('petugas.hewan.index') }}" class="rounded-lg bg-white p-4 font-medium text-gray-800 shadow hover:bg-gray-50">Kelola data hewan</a>
            <a href="{{ route('petugas.adopsi.index') }}" class="rounded-lg bg-white p-4 font-medium text-gray-800 shadow hover:bg-gray-50">Proses pengajuan adopsi</a>
        </div>

        <div class="mt-8 rounded-lg bg-white p-6 shadow">
            <h3 class="font-semibold text-gray-800">Pengajuan menunggu keputusan</h3>
            <ul class="mt-4 divide-y text-sm">
                @forelse ($terbaru as $application)
                    <li class="flex items-center justify-between gap-4 py-3">
                        <span><strong>{{ $application->user->name }}</strong> mengajukan <strong>{{ $application->hewan->nama }}</strong></span>
                        <span class="text-gray-500">{{ $application->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                @empty
                    <li class="py-3 text-gray-500">Tidak ada pengajuan yang menunggu.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
