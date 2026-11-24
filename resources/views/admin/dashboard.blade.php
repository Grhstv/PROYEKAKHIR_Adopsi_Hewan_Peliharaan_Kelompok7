<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Staf Shelter</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([
                ['Total hewan', $totalHewan], ['Tersedia', $totalTersedia], ['Teradopsi', $totalTeradopsi],
                ['Pengajuan menunggu', $totalMenunggu], ['Adopter', $totalAdopter],
            ] as [$label, $nilai])
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="text-3xl font-bold text-indigo-600">{{ $nilai }}</div>
                    <div class="text-sm text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-lg bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Pengajuan menunggu keputusan</h3>
                <a href="{{ route('admin.adopsi.index') }}" class="text-sm text-indigo-600 hover:underline">Kelola semua</a>
            </div>
            <ul class="mt-4 divide-y text-sm">
                @forelse ($terbaru as $a)
                    <li class="flex items-center justify-between py-3">
                        <span><strong>{{ $a->user->name }}</strong> mengajukan <strong>{{ $a->hewan->nama }}</strong></span>
                        <span class="text-gray-500">{{ $a->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                @empty
                    <li class="py-3 text-gray-500">Tidak ada pengajuan yang menunggu.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
