<a href="{{ route('hewan.show', $hewan) }}" class="block overflow-hidden rounded-lg bg-white shadow transition hover:shadow-lg">
    <img src="{{ $hewan->foto_src }}" alt="Foto {{ $hewan->nama }}" class="h-48 w-full object-cover" loading="lazy">
    <div class="p-4">
        <div class="flex items-start justify-between">
            <h3 class="text-lg font-semibold text-gray-800">{{ $hewan->nama }}</h3>
            <x-badge :status="$hewan->status" />
        </div>
        <p class="text-sm text-gray-500">{{ $hewan->kategori->nama }} &middot; {{ $hewan->ras ?? 'Campuran' }}</p>
        <p class="mt-2 text-sm text-gray-600">
            {{ ucfirst($hewan->jenis_kelamin) }} &middot; {{ $hewan->umur_label }}
        </p>
    </div>
</a>
