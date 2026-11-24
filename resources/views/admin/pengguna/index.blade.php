<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Kelola Pengguna</h2></x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Ubah role</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($users as $u)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                            <td class="px-4 py-3">{{ $u->email }}</td>
                            <td class="px-4 py-3">{{ $u->roles->pluck('name')->implode(', ') ?: '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($u->id !== Auth::id())
                                    <form method="POST" action="{{ route('admin.pengguna.role', $u) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="rounded-md border-gray-300 text-sm">
                                            @foreach ($roles as $r)
                                                <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                                            @endforeach
                                        </select>
                                        <button class="rounded-md bg-gray-800 px-3 text-sm font-semibold text-white">Simpan</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">(akun Anda)</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
