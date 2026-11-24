<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HewanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nama'          => $this->nama,
            'ras'           => $this->ras,
            'jenis_kelamin' => $this->jenis_kelamin,
            'umur_bulan'    => $this->umur_bulan,
            'umur'          => $this->umur_label,
            'warna'         => $this->warna,
            'deskripsi'     => $this->deskripsi,
            'kesehatan'     => $this->kesehatan,
            'sudah_vaksin'  => $this->sudah_vaksin,
            'sudah_steril'  => $this->sudah_steril,
            'status'        => $this->status,
            'foto'          => $this->foto_asli,
            'kategori'      => new KategoriResource($this->whenLoaded('kategori')),
            'dibuat'        => $this->created_at?->format('Y-m-d'),
        ];
    }
}
