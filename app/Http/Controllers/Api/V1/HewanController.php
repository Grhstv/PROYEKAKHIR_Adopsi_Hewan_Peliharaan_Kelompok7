<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HewanRequest;
use App\Http\Resources\V1\HewanResource;
use App\Models\Hewan;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    public function index(Request $request)
    {
        $data = Hewan::with('kategori')
            ->cari($request->input('cari'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->integer('kategori')))
            ->when(in_array($request->input('status'), [Hewan::TERSEDIA, Hewan::TERADOPSI], true),
                fn ($q) => $q->where('status', $request->input('status')))
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return HewanResource::collection($data);
    }

    public function show(Hewan $hewan)
    {
        return new HewanResource($hewan->load('kategori'));
    }

    public function store(HewanRequest $request)
    {
        abort_unless($request->user()->can('kelola hewan'), 403, 'Anda tidak memiliki izin.');

        $data = $request->dataHewan();
        $data['status'] ??= Hewan::TERSEDIA;
        $hewan = Hewan::create($data);

        return (new HewanResource($hewan->load('kategori')))->response()->setStatusCode(201);
    }

    public function update(HewanRequest $request, Hewan $hewan)
    {
        abort_unless($request->user()->can('kelola hewan'), 403, 'Anda tidak memiliki izin.');

        $hewan->update($request->dataHewan());

        return new HewanResource($hewan->load('kategori'));
    }

    public function destroy(Request $request, Hewan $hewan)
    {
        abort_unless($request->user()->can('kelola hewan'), 403, 'Anda tidak memiliki izin.');

        if ($hewan->adopsis()->exists()) {
            return response()->json(['message' => 'Hewan memiliki riwayat adopsi dan tidak dapat dihapus.'], 409);
        }
        $hewan->delete();

        return response()->noContent();
    }
}
