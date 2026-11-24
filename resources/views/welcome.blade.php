<x-app-layout>
    <section class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl font-bold">Temukan sahabat berbulu barumu 🐶🐱</h1>
            <p class="mt-4 text-lg text-indigo-100">Adopsi, jangan beli. Setiap hewan di sini sudah dirawat dan menunggu rumah yang penuh kasih.</p>
            <form action="{{ route('hewan.index') }}" method="GET" class="mt-8 mx-auto flex max-w-xl gap-2">
                <input type="text" name="cari" placeholder="Cari nama atau ras hewan..."
                       class="w-full rounded-md border-0 px-4 py-3 text-gray-900 focus:ring-2 focus:ring-yellow-300">
                <button class="rounded-md bg-yellow-400 px-5 py-3 font-semibold text-gray-900 hover:bg-yellow-300">Cari</button>
            </form>
            <div class="mt-8 flex justify-center gap-10 text-indigo-100">
                <div><div class="text-3xl font-bold text-white">{{ $totalTersedia }}</div>menunggu adopsi</div>
                <div><div class="text-3xl font-bold text-white">{{ $totalTeradopsi }}</div>sudah teradopsi</div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-wrap gap-2">
            @foreach ($kategoris as $k)
                <a href="{{ route('hewan.index', ['kategori' => $k->id]) }}"
                   class="rounded-full bg-white px-4 py-2 text-sm shadow hover:bg-indigo-50">
                    {{ $k->nama }} <span class="text-gray-400">({{ $k->hewans_count }})</span>
                </a>
            @endforeach
        </div>

        <h2 class="mt-10 text-2xl font-bold text-gray-800">Baru menunggu adopsi</h2>
        <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($terbaru as $hewan)
                @include('hewan._card', ['hewan' => $hewan])
            @empty
                <p class="text-gray-500">Belum ada hewan yang tersedia.</p>
            @endforelse
        </div>

        <h2 class="mt-12 text-2xl font-bold text-gray-800">Cara adopsi</h2>
        <div class="mt-4 grid gap-6 sm:grid-cols-3">
            <div class="rounded-lg bg-white p-6 shadow"><div class="text-3xl">1️⃣</div><h3 class="mt-2 font-semibold">Pilih hewan</h3><p class="mt-1 text-sm text-gray-600">Telusuri daftar hewan dan baca profil lengkapnya.</p></div>
            <div class="rounded-lg bg-white p-6 shadow"><div class="text-3xl">2️⃣</div><h3 class="mt-2 font-semibold">Ajukan adopsi</h3><p class="mt-1 text-sm text-gray-600">Daftar atau masuk, lalu isi formulir pengajuan.</p></div>
            <div class="rounded-lg bg-white p-6 shadow"><div class="text-3xl">3️⃣</div><h3 class="mt-2 font-semibold">Tunggu konfirmasi</h3><p class="mt-1 text-sm text-gray-600">Admin shelter memeriksa pengajuan dan menghubungi Anda.</p></div>
        </div>
    </div>
</x-app-layout>
