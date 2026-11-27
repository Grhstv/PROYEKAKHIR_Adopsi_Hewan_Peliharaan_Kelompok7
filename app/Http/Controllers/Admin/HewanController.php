<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HewanRequest;
use App\Models\Hewan;
use App\Models\HewanMutation;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HewanController extends Controller
{
    public function index(Request $request)
    {
        $hewans = Hewan::with('kategori')
            ->cari($request->input('cari'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->integer('kategori')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.hewan.index', [
            'hewans' => $hewans,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function create()
    {
        return view('admin.hewan.create', [
            'hewan' => new Hewan(['status' => Hewan::TERSEDIA, 'jenis_kelamin' => 'jantan']),
            'kategoris' => Kategori::orderBy('nama')->get(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function store(HewanRequest $request)
    {
        $data = $request->dataHewan();
        $data['status'] ??= Hewan::TERSEDIA;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('hewan', 'public');
        }

        $hewan = Hewan::create($data);
        HewanMutation::create([
            'hewan_id' => $hewan->id,
            'nama_hewan' => $hewan->nama,
            'jenis' => HewanMutation::DITAMBAHKAN,
            'user_id' => $request->user()->id,
            'keterangan' => 'Hewan ditambahkan ke daftar shelter.',
        ]);

        return redirect()->route($this->routePrefix().'.hewan.index')->with('success', 'Data hewan ditambahkan.');
    }

    public function edit(Hewan $hewan)
    {
        return view('admin.hewan.edit', [
            'hewan' => $hewan,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function update(HewanRequest $request, Hewan $hewan)
    {
        $data = $request->dataHewan();

        if ($request->hasFile('foto')) {
            if ($hewan->foto) {
                Storage::disk('public')->delete($hewan->foto);
            }
            $data['foto'] = $request->file('foto')->store('hewan', 'public');
        }

        $hewan->update($data);

        return redirect()->route($this->routePrefix().'.hewan.index')->with('success', 'Data hewan diperbarui.');
    }

    public function destroy(Hewan $hewan)
    {
        if ($hewan->adopsis()->exists()) {
            return back()->with('error', 'Hewan ini memiliki riwayat pengajuan adopsi sehingga tidak dapat dihapus.');
        }

        if ($hewan->foto) {
            Storage::disk('public')->delete($hewan->foto);
        }
        HewanMutation::create([
            'hewan_id' => null,
            'nama_hewan' => $hewan->nama,
            'jenis' => HewanMutation::DIHAPUS,
            'user_id' => request()->user()->id,
            'keterangan' => 'Data hewan dihapus dari daftar shelter.',
        ]);
        $hewan->delete();

        return redirect()->route($this->routePrefix().'.hewan.index')->with('success', 'Data hewan dihapus.');
    }

    private function routePrefix(): string
    {
        return request()->routeIs('petugas.*') ? 'petugas' : 'admin';
    }
}
