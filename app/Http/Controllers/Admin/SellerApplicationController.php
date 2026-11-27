<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerApplication;
use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerApplicationController extends Controller
{
    public function index(): View
    {
        $applications = SellerApplication::with(['user', 'processor'])->latest()->paginate(15);

        return view('admin.seller-applications.index', compact('applications'));
    }

    public function approve(Request $request, SellerApplication $sellerApplication): RedirectResponse
    {
        $data = $request->validate(['admin_note' => ['nullable', 'string', 'max:500']]);

        if ($sellerApplication->status !== SellerApplication::MENUNGGU) {
            return back()->with('error', 'Pengajuan seller ini sudah diproses.');
        }

        $approved = DB::transaction(function () use ($sellerApplication, $request, $data): bool {
            $application = SellerApplication::whereKey($sellerApplication->id)->lockForUpdate()->firstOrFail();

            if ($application->status !== SellerApplication::MENUNGGU || $application->user->shop()->exists()) {
                return false;
            }

            Shop::create([
                'owner_id' => $application->user_id,
                'name' => $application->store_name,
                'slug' => Str::slug($application->store_name).'-'.$application->user_id,
                'description' => $application->store_description,
                'address' => $application->address,
                'phone' => $application->phone,
                'active' => true,
            ]);

            $application->update([
                'status' => SellerApplication::DISETUJUI,
                'admin_note' => $data['admin_note'] ?? null,
                'processed_by' => $request->user()->id,
            ]);
            $application->user->assignRole('seller');

            return true;
        });

        if (! $approved) {
            return back()->with('error', 'Pengajuan tidak lagi menunggu atau pengguna sudah memiliki toko.');
        }

        return back()->with('success', 'Pengajuan disetujui. Toko seller sudah aktif.');
    }

    public function reject(Request $request, SellerApplication $sellerApplication): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        if ($sellerApplication->status !== SellerApplication::MENUNGGU) {
            return back()->with('error', 'Pengajuan seller ini sudah diproses.');
        }

        $sellerApplication->update([
            'status' => SellerApplication::DITOLAK,
            'admin_note' => $data['admin_note'],
            'processed_by' => $request->user()->id,
        ]);

        return back()->with('success', 'Pengajuan seller ditolak.');
    }
}
