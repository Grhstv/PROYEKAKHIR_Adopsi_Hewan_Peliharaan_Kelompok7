<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pengajuan Adopsi</h2></x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-4 flex flex-wrap gap-2 text-sm">
            @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dibatalkan' => 'Dibatalkan', 'semua' => 'Semua'] as $v => $l)
                <a href="{{ route('admin.adopsi.index', ['status' => $v]) }}"
                   class="rounded-full px-4 py-1.5 {{ $status === $v ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 shadow' }}">{{ $l }}</a>
            @endforeach
        </div>

        <div class="space-y-4">
            @forelse ($adopsis as $a)
                <div class="rounded-lg bg-white p-5 shadow">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div>
                            <div class="font-semibold text-gray-800">{{ $a->user->name }} <span class="font-normal text-gray-500">&middot; {{ $a->user->email }}</span></div>
                            <div class="text-sm text-gray-600">Mengajukan <a href="{{ route('hewan.show', $a->hewan) }}" class="font-medium text-indigo-600 hover:underline">{{ $a->hewan->nama }}</a> ({{ $a->hewan->kategori->nama }})</div>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            <x-badge :status="$a->status" />
                            <div class="mt-1">{{ $a->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <dl class="mt-3 grid gap-2 text-sm sm:grid-cols-3">
                        <div><dt class="text-gray-500">Telepon</dt><dd>{{ $a->no_telepon }}</dd></div>
                        <div><dt class="text-gray-500">Tempat tinggal</dt><dd>{{ str_replace('_', ' ', ucfirst($a->tempat_tinggal)) }}</dd></div>
                        <div><dt class="text-gray-500">Pengalaman</dt><dd>{{ str_replace('_', ' ', ucfirst($a->pengalaman)) }}</dd></div>
                    </dl>
                    <p class="mt-3 whitespace-pre-line rounded bg-gray-50 p-3 text-sm text-gray-700">{{ $a->alasan }}</p>

                    @if ($a->catatan_admin)
                        <p class="mt-2 text-sm text-gray-600"><strong>Catatan admin:</strong> {{ $a->catatan_admin }}</p>
                    @endif

                    @if ($a->status === 'menunggu')
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <form method="POST" action="{{ route('admin.adopsi.setujui', $a) }}" class="flex gap-2">
                                @csrf
                                <input type="text" name="catatan" placeholder="Catatan (opsional)" class="w-full rounded-md border-gray-300 text-sm">
                                <button class="rounded-md bg-green-600 px-4 text-sm font-semibold text-white hover:bg-green-500">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('admin.adopsi.tolak', $a) }}" class="flex gap-2">
                                @csrf
                                <input type="text" name="catatan" placeholder="Alasan penolakan (wajib)" class="w-full rounded-md border-gray-300 text-sm" required>
                                <button class="rounded-md bg-red-600 px-4 text-sm font-semibold text-white hover:bg-red-500">Tolak</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="rounded-lg bg-white p-8 text-center text-gray-500 shadow">Tidak ada pengajuan pada kategori ini.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $adopsis->links() }}</div>
    </div>
</x-app-layout>
