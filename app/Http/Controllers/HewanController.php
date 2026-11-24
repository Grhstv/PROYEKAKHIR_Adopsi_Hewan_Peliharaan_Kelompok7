<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\Kategori;
use Illuminate\Http\Request;

/** Katalog hewan untuk publik (tanpa login). */
class HewanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'tersedia');

        $hewans = Hewan::with('kategori')
            ->cari($request->input('cari'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->integer('kategori')))
            ->when(in_array($request->input('jenis_kelamin'), ['jantan', 'betina'], true),
                fn ($q) => $q->where('jenis_kelamin', $request->input('jenis_kelamin')))
            ->when(in_array($status, [Hewan::TERSEDIA, Hewan::TERADOPSI], true),
                fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('hewan.index', [
            'hewans'    => $hewans,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'status'    => $status,
        ]);
    }

    public function show(Request $request, Hewan $hewan)
    {
        $hewan->load('kategori');

        $sudahMengajukan = $request->user()
            ? Adopsi::where('user_id', $request->user()->id)
                ->where('hewan_id', $hewan->id)
                ->where('status', Adopsi::MENUNGGU)
                ->exists()
            : false;

        $serupa = Hewan::with('kategori')->tersedia()
            ->where('kategori_id', $hewan->kategori_id)
            ->where('id', '!=', $hewan->id)
            ->latest()->take(3)->get();

        return view('hewan.show', compact('hewan', 'sudahMengajukan', 'serupa'));
    }
}
