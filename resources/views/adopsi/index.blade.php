<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Adopsi Saya</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Hewan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Catatan admin</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($adopsis as $a)
                        <tr>
                            <td class="px-4 py-3">
                                <a href="{{ route('hewan.show', $a->hewan) }}" class="font-medium text-gray-800 hover:underline">{{ $a->hewan->nama }}</a>
                                <div class="text-xs text-gray-500">{{ $a->hewan->kategori->nama }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $a->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3"><x-badge :status="$a->status" /></td>
                            <td class="px-4 py-3 text-gray-600">{{ $a->catatan_admin ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                @can('cancel', $a)
                                    <form method="POST" action="{{ route('adopsi.destroy', $a) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Batalkan</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $adopsis->links() }}</div>
    </div>
</x-app-layout>
