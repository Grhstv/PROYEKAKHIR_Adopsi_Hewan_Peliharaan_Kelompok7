<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index', [
            'kategoris' => Kategori::withCount('hewans')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:50', 'unique:kategoris,nama'],
        ]);

        Kategori::create(['nama' => $data['nama'], 'slug' => Str::slug($data['nama'])]);

        return back()->with('success', 'Kategori ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'min:2', 'max:50', Rule::unique('kategoris', 'nama')->ignore($kategori->id)],
        ]);

        $kategori->update(['nama' => $data['nama'], 'slug' => Str::slug($data['nama'])]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->hewans()->exists()) {
            return back()->with('error', 'Kategori masih dipakai oleh data hewan.');
        }
        $kategori->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}
