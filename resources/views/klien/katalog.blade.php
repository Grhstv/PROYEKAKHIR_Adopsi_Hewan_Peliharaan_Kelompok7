<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Katalog Live (dimuat lewat REST API)</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class="mb-4 text-sm text-gray-600">Halaman ini mengambil data dari <code>/api/v1/hewan</code> memakai <strong>Fetch API</strong> dan async/await, tanpa memuat ulang halaman.</p>

        <form id="form-cari" class="mb-6 grid gap-3 rounded-lg bg-white p-4 shadow sm:grid-cols-4">
            <input id="cari" type="text" placeholder="Cari nama / ras" class="rounded-md border-gray-300 text-sm sm:col-span-2">
            <select id="kategori" class="rounded-md border-gray-300 text-sm"><option value="">Semua jenis</option></select>
            <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Cari</button>
        </form>

        <div id="pesan" class="mb-4 text-sm"></div>
        <div id="grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"></div>

        <div class="mt-6 flex items-center justify-center gap-4 text-sm">
            <button id="btn-prev" class="rounded-md bg-white px-4 py-2 shadow disabled:opacity-40">&laquo; Sebelumnya</button>
            <span id="info"></span>
            <button id="btn-next" class="rounded-md bg-white px-4 py-2 shadow disabled:opacity-40">Berikutnya &raquo;</button>
        </div>
    </div>

    <script>
        const API = '/api/v1';
        let halaman = 1;
        const $ = (id) => document.getElementById(id);

        // Satu pintu untuk semua request; menerjemahkan kegagalan menjadi pesan yang jelas.
        async function apiGet(path) {
            let res;
            try {
                res = await fetch(API + path, { headers: { Accept: 'application/json' } });
            } catch (e) {
                throw new Error('Tidak dapat terhubung ke server.');
            }
            if (!res.ok) {
                throw new Error('Gagal memuat data (kode ' + res.status + ').');
            }
            return res.json();
        }

        function tampilPesan(teks, galat = true) {
            const el = $('pesan');
            el.textContent = teks || '';
            el.className = 'mb-4 text-sm ' + (galat ? 'text-red-600' : 'text-gray-600');
        }

        // Data dibangun dengan DOM + textContent (bukan innerHTML) agar aman dari XSS.
        function buatKartu(h) {
            const a = document.createElement('a');
            a.href = '/hewan/' + encodeURIComponent(h.id);
            a.className = 'block overflow-hidden rounded-lg bg-white shadow hover:shadow-lg';

            const img = document.createElement('img');
            img.className = 'h-48 w-full object-cover';
            img.alt = 'Foto ' + h.nama;
            img.src = h.foto || 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
                '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400"><rect width="100%" height="100%" fill="#e2e8f0"/></svg>');
            a.appendChild(img);

            const body = document.createElement('div');
            body.className = 'p-4';
            const judul = document.createElement('h3');
            judul.className = 'text-lg font-semibold text-gray-800';
            judul.textContent = h.nama;
            const sub = document.createElement('p');
            sub.className = 'text-sm text-gray-500';
            sub.textContent = (h.kategori ? h.kategori.nama : '') + ' · ' + (h.ras || 'Campuran');
            const info = document.createElement('p');
            info.className = 'mt-2 text-sm text-gray-600';
            info.textContent = h.jenis_kelamin + ' · ' + h.umur + ' · ' + h.status;
            body.append(judul, sub, info);
            a.appendChild(body);
            return a;
        }

        async function muatKategori() {
            try {
                const d = await apiGet('/kategori');
                d.data.forEach((k) => {
                    const o = document.createElement('option');
                    o.value = k.id;
                    o.textContent = k.nama;
                    $('kategori').appendChild(o);
                });
            } catch (e) { /* filter kategori opsional */ }
        }

        async function muatHewan(h = 1) {
            tampilPesan('Memuat...', false);
            const p = new URLSearchParams({ page: h, status: 'tersedia' });
            if ($('cari').value.trim()) p.set('cari', $('cari').value.trim());
            if ($('kategori').value) p.set('kategori', $('kategori').value);

            try {
                const d = await apiGet('/hewan?' + p.toString());
                halaman = d.meta.current_page;
                $('grid').replaceChildren(...d.data.map(buatKartu));
                tampilPesan(d.data.length ? '' : 'Tidak ada hewan yang cocok.', false);
                $('info').textContent = 'Halaman ' + d.meta.current_page + ' dari ' + d.meta.last_page + ' (' + d.meta.total + ' hewan)';
                $('btn-prev').disabled = !d.links.prev;
                $('btn-next').disabled = !d.links.next;
            } catch (e) {
                $('grid').replaceChildren();
                tampilPesan(e.message);
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            $('form-cari').onsubmit = (e) => { e.preventDefault(); muatHewan(1); };
            $('btn-prev').onclick = () => muatHewan(halaman - 1);
            $('btn-next').onclick = () => muatHewan(halaman + 1);
            await muatKategori();
            await muatHewan(1);
        });
    </script>
</x-app-layout>
