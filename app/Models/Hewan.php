<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Hewan extends Model
{
    public const TERSEDIA = 'tersedia';
    public const TERADOPSI = 'teradopsi';

    // Nama tabel eksplisit karena "hewan" tidak mengikuti aturan jamak bahasa Inggris.
    protected $table = 'hewans';

    protected $fillable = [
        'kategori_id', 'nama', 'ras', 'jenis_kelamin', 'umur_bulan', 'warna',
        'deskripsi', 'kesehatan', 'sudah_vaksin', 'sudah_steril',
        'foto', 'foto_url', 'status',
    ];

    protected function casts(): array
    {
        return [
            'sudah_vaksin' => 'boolean',
            'sudah_steril' => 'boolean',
            'umur_bulan' => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function adopsis(): HasMany
    {
        return $this->hasMany(Adopsi::class);
    }

    /* ---------- Scope ---------- */

    public function scopeTersedia(Builder $q): Builder
    {
        return $q->where('status', self::TERSEDIA);
    }

    /** Pencarian nama/ras tanpa peduli huruf besar-kecil (aman untuk MySQL dan PostgreSQL), memakai binding. */
    public function scopeCari(Builder $q, ?string $kata): Builder
    {
        if (! $kata) {
            return $q;
        }
        $pola = '%'.mb_strtolower($kata).'%';

        return $q->where(function (Builder $w) use ($pola) {
            $w->whereRaw('LOWER(nama) LIKE ?', [$pola])
              ->orWhereRaw('LOWER(ras) LIKE ?', [$pola]);
        });
    }

    /* ---------- Accessor ---------- */

    /** Foto asli (upload atau URL); null jika tidak ada. */
    protected function fotoAsli(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->foto) {
                return Storage::disk('public')->url($this->foto);
            }

            return $this->foto_url ?: null;
        });
    }

    /** Foto untuk ditampilkan; jika kosong dipakai gambar SVG pengganti (tanpa request luar). */
    protected function fotoSrc(): Attribute
    {
        return Attribute::make(get: function () {
            if ($asli = $this->foto_asli) {
                return $asli;
            }
            $teks = htmlspecialchars((string) $this->nama, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400">'
                 .'<rect width="100%" height="100%" fill="#e2e8f0"/>'
                 .'<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" '
                 .'font-family="sans-serif" font-size="34" fill="#64748b">'.$teks.'</text></svg>';

            return 'data:image/svg+xml;charset=UTF-8,'.rawurlencode($svg);
        });
    }

    protected function umurLabel(): Attribute
    {
        return Attribute::make(get: function () {
            $tahun = intdiv($this->umur_bulan, 12);
            $bulan = $this->umur_bulan % 12;
            $bagian = [];
            if ($tahun > 0) {
                $bagian[] = $tahun.' tahun';
            }
            if ($bulan > 0 || $tahun === 0) {
                $bagian[] = $bulan.' bulan';
            }

            return implode(' ', $bagian);
        });
    }
}
