<?php

namespace App\Http\Controllers;

use App\Models\SellerApplication;
use App\Support\PhoneNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerApplicationController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()->shop()->exists()) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.application', [
            'application' => $request->user()->sellerApplications()->latest()->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:120'],
            'store_description' => ['required', 'string', 'min:20', 'max:2000'],
            'address' => ['required', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\s().-]{8,24}$/'],
        ]);

        $phone = PhoneNumber::normalize($data['phone']);
        $latestApplication = $request->user()->sellerApplications()->latest()->first();

        if ($latestApplication?->status === SellerApplication::MENUNGGU) {
            return back()->withInput()->with('error', 'Pengajuan seller Anda masih menunggu pemeriksaan admin.');
        }

        $request->user()->sellerApplications()->create([
            ...$data,
            'phone' => $phone,
            'status' => SellerApplication::MENUNGGU,
        ]);

        return redirect()->route('seller.application.create')->with('success', 'Pengajuan seller terkirim dan menunggu persetujuan admin.');
    }
}
