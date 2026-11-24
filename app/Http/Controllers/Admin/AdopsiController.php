<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adopsi;
use App\Models\Hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdopsiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', Adopsi::MENUNGGU);

        $adopsis = Adopsi::with(['user', 'hewan.kategori'])
            ->when(in_array($status, [Adopsi::MENUNGGU, Adopsi::DISETUJUI, Adopsi::DITOLAK, Adopsi::DIBATALKAN], true),
                fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.adopsi.index', compact('adopsis', 'status'));
    }

    public function setujui(Request $request, Adopsi $adopsi)
    {
        $data = $request->validate(['catatan' => ['nullable', 'string', 'max:500']]);

        $galat = DB::transaction(function () use ($adopsi, $data) {
            $a = Adopsi::whereKey($adopsi->id)->lockForUpdate()->firstOrFail();
            if ($a->status !== Adopsi::MENUNGGU) {
                return 'Pengajuan ini sudah diproses.';
            }

            $h = Hewan::whereKey($a->hewan_id)->lockForUpdate()->firstOrFail();
            if ($h->status !== Hewan::TERSEDIA) {
                return 'Hewan sudah tidak tersedia.';
            }

            $a->update([
                'status'        => Adopsi::DISETUJUI,
                'catatan_admin' => $data['catatan'] ?? null,
                'diproses_at'   => now(),
            ]);
            $h->update(['status' => Hewan::TERADOPSI]);

            // Pengajuan lain untuk hewan yang sama otomatis ditolak.
            Adopsi::where('hewan_id', $h->id)
                ->where('id', '!=', $a->id)
                ->where('status', Adopsi::MENUNGGU)
                ->update([
                    'status'        => Adopsi::DITOLAK,
                    'catatan_admin' => 'Hewan sudah diadopsi oleh pemohon lain.',
                    'diproses_at'   => now(),
                ]);

            return null;
        });

        return back()->with($galat ? 'error' : 'success', $galat ?? 'Pengajuan disetujui. Hewan ditandai teradopsi.');
    }

    public function tolak(Request $request, Adopsi $adopsi)
    {
        $data = $request->validate(['catatan' => ['required', 'string', 'max:500']], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($adopsi->status !== Adopsi::MENUNGGU) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $adopsi->update([
            'status'        => Adopsi::DITOLAK,
            'catatan_admin' => $data['catatan'],
            'diproses_at'   => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}
