<?php

namespace App\Http\Requests;

use App\Models\Hewan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Dipakai untuk tambah dan ubah hewan (web admin maupun API). */
class HewanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi dilakukan di route (can:kelola hewan)
    }

    public function rules(): array
    {
        return [
            'kategori_id'   => ['required', 'integer', 'exists:kategoris,id'],
            'nama'          => ['required', 'string', 'min:2', 'max:100'],
            'ras'           => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['required', Rule::in(['jantan', 'betina'])],
            'umur_bulan'    => ['required', 'integer', 'min:0', 'max:360'],
            'warna'         => ['nullable', 'string', 'max:50'],
            'deskripsi'     => ['required', 'string', 'min:20', 'max:2000'],
            'kesehatan'     => ['nullable', 'string', 'max:500'],
            'sudah_vaksin'  => ['nullable', 'boolean'],
            'sudah_steril'  => ['nullable', 'boolean'],
            'status'        => ['nullable', Rule::in([Hewan::TERSEDIA, Hewan::TERADOPSI])],
            'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'foto_url'      => ['nullable', 'url:http,https', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'  => ':attribute wajib diisi.',
            'min'       => ':attribute minimal :min karakter/nilai.',
            'max'       => ':attribute maksimal :max.',
            'in'        => ':attribute tidak valid.',
            'exists'    => ':attribute tidak ditemukan.',
            'integer'   => ':attribute harus berupa angka bulat.',
            'image'     => ':attribute harus berupa gambar.',
            'mimes'     => ':attribute harus berformat jpg, jpeg, png, atau webp.',
            'url'       => ':attribute harus berupa URL http/https yang valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'   => 'Kategori',
            'nama'          => 'Nama hewan',
            'ras'           => 'Ras',
            'jenis_kelamin' => 'Jenis kelamin',
            'umur_bulan'    => 'Umur (bulan)',
            'warna'         => 'Warna',
            'deskripsi'     => 'Deskripsi',
            'kesehatan'     => 'Kondisi kesehatan',
            'status'        => 'Status',
            'foto'          => 'Foto',
            'foto_url'      => 'URL foto',
        ];
    }

    /** Data siap simpan (tanpa berkas foto). Status tidak diisi default di sini agar update tidak mereset status. */
    public function dataHewan(): array
    {
        $data = $this->safe()->except(['foto']);
        $data['sudah_vaksin'] = $this->boolean('sudah_vaksin');
        $data['sudah_steril'] = $this->boolean('sudah_steril');

        return $data;
    }
}
