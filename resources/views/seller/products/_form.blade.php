@csrf
<div class="space-y-4">
    <div>
        <x-input-label for="name" value="Nama produk" />
        <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $product?->name)" required />
        <x-input-error :messages="$errors->get('name')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="category" value="Kategori" />
        <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $product?->category) === $category)>{{ $category }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="description" value="Deskripsi produk" />
        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description', $product?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-1" />
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <x-input-label for="price" value="Harga (Rp)" />
            <x-text-input id="price" name="price" type="number" min="1000" max="100000000" step="1" class="mt-1 block w-full" :value="old('price', $product?->price)" required />
            <x-input-error :messages="$errors->get('price')" class="mt-1" />
        </div>
        <div>
            <x-input-label for="stock" value="Stok" />
            <x-text-input id="stock" name="stock" type="number" min="0" max="100000" class="mt-1 block w-full" :value="old('stock', $product?->stock ?? 0)" required />
            <x-input-error :messages="$errors->get('stock')" class="mt-1" />
        </div>
    </div>
    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
        <input type="hidden" name="active" value="0">
        <input type="checkbox" name="active" value="1" class="rounded border-gray-300" @checked(old('active', $product?->active ?? true))>
        Tampilkan produk di marketplace
    </label>
</div>
