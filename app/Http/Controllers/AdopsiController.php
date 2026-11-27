<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdopsiRequest;
use App\Models\Adopsi;
use App\Models\Hewan;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/** Fitur untuk adopter: ajukan, lihat riwayat, batalkan pengajuan milik sendiri. */
class AdopsiController extends Controller
{
    public function create(Request $request, Hewan $hewan)
    {
        if ($hewan->status !== Hewan::TERSEDIA) {
            return redirect()->route('hewan.show', $hewan)->with('error', 'Hewan ini sudah tidak tersedia untuk diadopsi.');
        }

        $sudah = Adopsi::where('user_id', $request->user()->id)
            ->where('hewan_id', $hewan->id)->where('status', Adopsi::MENUNGGU)->exists();
        if ($sudah) {
            return redirect()->route('adopsi.index')->with('error', 'Anda sudah mengajukan adopsi untuk hewan ini.');
        }

        $terms = TermsAndCondition::where('key', TermsAndCondition::KEY)->value('content')
            ?? TermsAndCondition::DEFAULT_CONTENT;

        return view('adopsi.create', compact('hewan', 'terms'));
    }

    public function store(AdopsiRequest $request, Hewan $hewan)
    {
        $user = $request->user();
        $data = $request->safe()->except(['setuju', 'setuju_terms']);
        $terms = TermsAndCondition::where('key', TermsAndCondition::KEY)->value('content')
            ?? TermsAndCondition::DEFAULT_CONTENT;

        $galat = DB::transaction(function () use ($user, $hewan, $data, $terms) {
            $h = Hewan::whereKey($hewan->id)->lockForUpdate()->firstOrFail();

            if ($h->status !== Hewan::TERSEDIA) {
                return 'Hewan ini sudah tidak tersedia untuk diadopsi.';
            }

            $menunggu = Adopsi::where('user_id', $user->id)->where('status', Adopsi::MENUNGGU);

            if ((clone $menunggu)->where('hewan_id', $h->id)->exists()) {
                return 'Anda sudah mengajukan adopsi untuk hewan ini dan masih menunggu keputusan.';
            }
            if ((clone $menunggu)->count() >= 3) {
                return 'Maksimal 3 pengajuan yang boleh menunggu keputusan sekaligus.';
            }

            Adopsi::create($data + [
                'user_id' => $user->id,
                'hewan_id' => $h->id,
                'status' => Adopsi::MENUNGGU,
                'terms_snapshot' => $terms,
                'terms_accepted_at' => now(),
            ]);

            return null;
        });

        if ($galat) {
            return back()->withInput()->with('error', $galat);
        }

        return redirect()->route('adopsi.index')->with('success', 'Pengajuan adopsi terkirim. Tunggu konfirmasi dari admin.');
    }

    /** Riwayat milik sendiri: query selalu dibatasi user yang login. */
    public function index(Request $request)
    {
        $adopsis = $request->user()->adopsis()
            ->with('hewan.kategori')
            ->latest()
            ->paginate(10);

        return view('adopsi.index', compact('adopsis'));
    }

    public function destroy(Request $request, Adopsi $adopsi)
    {
        Gate::authorize('cancel', $adopsi); // 403 jika bukan pemilik atau status bukan menunggu

        $adopsi->update(['status' => Adopsi::DIBATALKAN, 'diproses_at' => now()]);

        return back()->with('success', 'Pengajuan dibatalkan.');
    }
}
