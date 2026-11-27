<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdopsiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi di route (can:mengajukan adopsi)
    }

    public function rules(): array
    {
        return [
            'alasan' => ['required', 'string', 'min:20', 'max:1000'],
            'tempat_tinggal' => ['required', Rule::in(['rumah_sendiri', 'kontrakan', 'kos', 'apartemen'])],
            'pengalaman' => ['required', Rule::in(['belum_pernah', 'pernah', 'berpengalaman'])],
            'no_telepon' => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'alamat_lengkap' => ['required', 'string', 'min:10', 'max:1000'],
            'persetujuan_keluarga' => ['accepted'],
            'jadwal_perawatan' => ['required', 'string', 'max:100'],
            'anggaran_bulanan' => ['required', 'integer', 'min:0', 'max:100000000'],
            'rencana_perawatan' => ['required', 'string', 'min:20', 'max:2000'],
            'setuju' => ['accepted'],
            'setuju_terms' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => ':attribute tidak valid.',
            'regex' => ':attribute harus 8-20 karakter berisi angka, spasi, + atau -.',
            'accepted' => 'Anda harus menyetujui pernyataan kesanggupan merawat.',
        ];
    }

    public function attributes(): array
    {
        return [
            'alasan' => 'Alasan adopsi',
            'tempat_tinggal' => 'Tempat tinggal',
            'pengalaman' => 'Pengalaman memelihara',
            'no_telepon' => 'Nomor telepon',
            'alamat_lengkap' => 'Alamat lengkap',
            'persetujuan_keluarga' => 'Persetujuan keluarga/penghuni rumah',
            'jadwal_perawatan' => 'Jadwal perawatan',
            'anggaran_bulanan' => 'Anggaran perawatan per bulan',
            'rencana_perawatan' => 'Rencana perawatan',
            'setuju_terms' => 'Syarat dan ketentuan adopsi',
        ];
    }
}
