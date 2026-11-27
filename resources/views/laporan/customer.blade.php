<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Laporan Adopsi Saya</h2>
            <button type="button" onclick="window.print()" class="no-print rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Cetak / Simpan PDF
            </button>
        </div>
    </x-slot>

    <style>
        @media print {
            nav, footer, header, .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; }
            .print-page { box-shadow: none !important; margin: 0 !important; }
            table { font-size: 10px; }
        }
    </style>

    <div class="print-page max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-2 text-lg font-semibold">{{ Auth::user()->name }}</div>
        <div class="mb-6 text-sm text-gray-500">{{ Auth::user()->email }} &middot; Dicetak {{ now()->format('d/m/Y H:i') }}</div>

        <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ([
                'menunggu' => 'Menunggu',
                'disetujui' => 'Disetujui',
                'ditolak' => 'Ditolak',
                'dibatalkan' => 'Dibatalkan',
            ] as $status => $label)
                <div class="rounded-lg bg-white p-4 shadow">
                    <div class="text-2xl font-bold text-indigo-600">{{ $ringkasan[$status] }}</div>
                    <div class="text-sm text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-3 py-3">ID</th>
                        <th class="px-3 py-3">Hewan</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">Status</th>
                        <th class="px-3 py-3">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($adopsis as $adopsi)
                        <tr>
                            <td class="px-3 py-3">{{ $adopsi->id }}</td>
                            <td class="px-3 py-3">{{ $adopsi->hewan->nama }}<div class="text-xs text-gray-500">{{ $adopsi->hewan->kategori->nama }}</div></td>
                            <td class="px-3 py-3">{{ $adopsi->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-3 py-3">{{ ucfirst($adopsi->status) }}</td>
                            <td class="px-3 py-3">{{ $adopsi->catatan_admin ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-8 text-center text-gray-500">Belum ada pengajuan adopsi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
