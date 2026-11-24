<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->can('lihat dashboard admin')) {
            return view('admin.dashboard', [
                'totalHewan'     => Hewan::count(),
                'totalTersedia'  => Hewan::tersedia()->count(),
                'totalTeradopsi' => Hewan::where('status', Hewan::TERADOPSI)->count(),
                'totalMenunggu'  => Adopsi::where('status', Adopsi::MENUNGGU)->count(),
                'totalAdopter'   => User::role('adopter')->count(),
                'terbaru'        => Adopsi::with(['user', 'hewan'])
                                        ->where('status', Adopsi::MENUNGGU)->latest()->take(5)->get(),
            ]);
        }

        $hitung = $user->adopsis()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('dashboard', [
            'ringkasan' => $hitung,
            'terakhir'  => $user->adopsis()->with('hewan')->latest()->take(5)->get(),
        ]);
    }
}
