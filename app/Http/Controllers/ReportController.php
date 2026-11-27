<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\HewanMutation;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    public function admin(): View
    {
        $adopsis = Adopsi::with(['user', 'hewan.kategori'])
            ->latest()
            ->get();
        $mutations = HewanMutation::with(['user'])
            ->latest()
            ->get();

        return view('admin.laporan.index', [
            'adopsis' => $adopsis,
            'mutations' => $mutations,
            'ringkasan' => [
                Adopsi::MENUNGGU => $adopsis->where('status', Adopsi::MENUNGGU)->count(),
                Adopsi::DISETUJUI => $adopsis->where('status', Adopsi::DISETUJUI)->count(),
                Adopsi::DITOLAK => $adopsis->where('status', Adopsi::DITOLAK)->count(),
                Adopsi::DIBATALKAN => $adopsis->where('status', Adopsi::DIBATALKAN)->count(),
            ],
            'ringkasanHewan' => [
                'semua' => Hewan::count(),
                'tersedia' => Hewan::where('status', Hewan::TERSEDIA)->count(),
                'teradopsi' => Hewan::where('status', Hewan::TERADOPSI)->count(),
                'ditambahkan' => $mutations->where('jenis', HewanMutation::DITAMBAHKAN)->count(),
                'dihapus' => $mutations->where('jenis', HewanMutation::DIHAPUS)->count(),
            ],
        ]);
    }
}
