<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'terbaru'        => Hewan::with('kategori')->tersedia()->latest()->take(6)->get(),
            'totalTersedia'  => Hewan::tersedia()->count(),
            'totalTeradopsi' => Hewan::where('status', Hewan::TERADOPSI)->count(),
            'kategoris'      => Kategori::withCount(['hewans' => fn ($q) => $q->where('status', Hewan::TERSEDIA)])
                                    ->orderBy('nama')->get(),
        ]);
    }
}
