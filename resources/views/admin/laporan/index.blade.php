<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800">Laporan Pengajuan Adopsi</h2>
            <button type="button" onclick="window.print()" class="no-print rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Cetak / Simpan PDF
            </button>
        </div>
    </x-slot>

    <style>
        @page { size: legal portrait; margin: 12mm; }

        @media print {
            nav, footer, header, .no-print { display: none !important; }
            body { background: white !important; }
            main { padding: 0 !important; }
            .print-page { box-shadow: none !important; margin: 0 !important; }
            table { font-size: 10px; }
        }
    </style>

    <div class="print-page max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 text-sm text-gray-500">Dicetak pada {{ now()->format('d/m/Y H:i') }}</div>

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

        <h3 class="mb-3 text-base font-semibold text-gray-800">Ringkasan Semua Hewan</h3>
        <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-5">
            @foreach ([
                'semua' => 'Semua hewan',
                'tersedia' => 'Masih tersedia',
                'teradopsi' => 'Sudah teradopsi',
                'ditambahkan' => 'Pernah ditambah',
                'dihapus' => 'Pernah dihapus',
            ] as $key => $label)
                <div class="rounded-lg bg-white p-4 shadow">
                    <div class="text-2xl font-bold text-emerald-600">{{ $ringkasanHewan[$key] }}</div>
                    <div class="text-sm text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <h3 class="mb-3 text-base font-semibold text-gray-800">Riwayat Bertambah dan Berkurang Hewan</h3>
        <div class="mb-6 overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">Nama Hewan</th>
                        <th class="px-3 py-3">Perubahan</th>
                        <th class="px-3 py-3">Petugas</th>
                        <th class="px-3 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($mutations as $mutation)
                        <tr>
                            <td class="px-3 py-3">{{ $mutation->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-3 py-3 font-medium">{{ $mutation->nama_hewan }}</td>
                            <td class="px-3 py-3">
                                @if ($mutation->jenis === \App\Models\HewanMutation::DITAMBAHKAN)
                                    <span class="font-semibold text-emerald-700">+ Bertambah</span>
                                @elseif ($mutation->jenis === \App\Models\HewanMutation::DIHAPUS)
                                    <span class="font-semibold text-red-700">- Berkurang</span>
                                @else
                                    <span class="font-semibold text-indigo-700">- Teradopsi</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">{{ $mutation->user?->name ?? '-' }}</td>
                            <td class="px-3 py-3">{{ $mutation->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-8 text-center text-gray-500">Belum ada riwayat perubahan hewan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-3 py-3">ID</th>
                        <th class="px-3 py-3">Pemohon</th>
                        <th class="px-3 py-3">Hewan</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">Status</th>
                        <th class="px-3 py-3">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($adopsis as $adopsi)
                        <tr>
                            <td class="px-3 py-3">{{ $adopsi->id }}</td>
                            <td class="px-3 py-3">{{ $adopsi->user->name }}<div class="text-xs text-gray-500">{{ $adopsi->user->email }}</div></td>
                            <td class="px-3 py-3">{{ $adopsi->hewan->nama }}</td>
                            <td class="px-3 py-3">{{ $adopsi->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-3 py-3">{{ ucfirst($adopsi->status) }}</td>
                            <td class="px-3 py-3">{{ $adopsi->catatan_admin ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-3 py-8 text-center text-gray-500">Belum ada pengajuan adopsi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
