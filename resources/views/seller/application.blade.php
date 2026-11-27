<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Pengajuan Menjadi Seller</h2></x-slot>
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        @if ($application)
            <div class="rounded-lg bg-white p-6 shadow">
                <p>Status pengajuan: <strong>{{ ucfirst($application->status) }}</strong></p>
                <p class="mt-2 text-sm text-gray-600">Nama toko: {{ $application->store_name }}</p>
                @if ($application->admin_note)
                    <p class="mt-3 rounded bg-gray-50 p-3 text-sm text-gray-700">Catatan admin: {{ $application->admin_note }}</p>
                @endif
                @if ($application->status === \App\Models\SellerApplication::DITOLAK)
                    <p class="mt-4 text-sm text-gray-600">Anda dapat memperbaiki data dan mengajukan kembali.</p>
                @endif
            </div>
        @endif

        @if (! $application || $application->status === \App\Models\SellerApplication::DITOLAK)
            <form method="POST" action="{{ route('seller.application.store') }}" class="mt-5 space-y-4 rounded-lg bg-white p-6 shadow">
                @csrf
                <p class="text-sm text-gray-600">Jual perlengkapan hewan seperti makanan, aksesori, dan produk perawatan. Toko akan aktif setelah admin menyetujui pengajuan.</p>
                <div>
                    <x-input-label for="store_name" value="Nama toko" />
                    <x-text-input id="store_name" name="store_name" class="mt-1 block w-full" :value="old('store_name', $application?->store_name)" required />
                    <x-input-error :messages="$errors->get('store_name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="store_description" value="Deskripsi toko" />
                    <textarea id="store_description" name="store_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('store_description', $application?->store_description) }}</textarea>
                    <x-input-error :messages="$errors->get('store_description')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="address" value="Alamat operasional" />
                    <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('address', $application?->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="phone" value="Nomor WhatsApp toko" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', auth()->user()->phone)" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>
                <x-primary-button>Kirim pengajuan</x-primary-button>
            </form>
        @endif
    </div>
</x-app-layout>
