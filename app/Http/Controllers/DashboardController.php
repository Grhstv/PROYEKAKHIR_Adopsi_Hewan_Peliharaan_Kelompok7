<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\SellerApplication;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->can('akses area admin')) {
            return Redirect::route('admin.dashboard');
        }

        if ($user->can('akses area petugas')) {
            return Redirect::route('petugas.dashboard');
        }

        $hitung = $user->adopsis()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('dashboard', [
            'ringkasan' => $hitung,
            'terakhir' => $user->adopsis()->with('hewan')->latest()->take(5)->get(),
        ]);
    }

    public function admin(): View
    {
        return view('admin.dashboard', [
            'totalHewan' => Hewan::count(),
            'totalTersedia' => Hewan::tersedia()->count(),
            'totalTeradopsi' => Hewan::where('status', Hewan::TERADOPSI)->count(),
            'totalMenunggu' => Adopsi::where('status', Adopsi::MENUNGGU)->count(),
            'totalAdopter' => User::role('adopter')->count(),
            'totalSeller' => User::role('seller')->count(),
            'totalPengajuanSeller' => SellerApplication::where('status', 'menunggu')->count(),
            'terbaru' => Adopsi::with(['user', 'hewan'])
                ->where('status', Adopsi::MENUNGGU)->latest()->take(5)->get(),
        ]);
    }

    public function petugas(): View
    {
        return view('petugas.dashboard', [
            'totalHewan' => Hewan::count(),
            'totalTersedia' => Hewan::tersedia()->count(),
            'totalTeradopsi' => Hewan::where('status', Hewan::TERADOPSI)->count(),
            'totalMenunggu' => Adopsi::where('status', Adopsi::MENUNGGU)->count(),
            'terbaru' => Adopsi::with(['user', 'hewan'])
                ->where('status', Adopsi::MENUNGGU)->latest()->take(5)->get(),
        ]);
    }
}
