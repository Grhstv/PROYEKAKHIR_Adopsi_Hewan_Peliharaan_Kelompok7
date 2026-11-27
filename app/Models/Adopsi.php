<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adopsi extends Model
{
    public const MENUNGGU = 'menunggu';

    public const DISETUJUI = 'disetujui';

    public const DITOLAK = 'ditolak';

    public const DIBATALKAN = 'dibatalkan';

    protected $table = 'adopsis';

    protected $fillable = [
        'user_id', 'hewan_id', 'alasan', 'tempat_tinggal', 'pengalaman',
        'no_telepon', 'alamat_lengkap', 'persetujuan_keluarga', 'jadwal_perawatan',
        'anggaran_bulanan', 'rencana_perawatan', 'terms_snapshot', 'terms_accepted_at',
        'status', 'catatan_admin', 'diproses_at',
    ];

    protected function casts(): array
    {
        return [
            'diproses_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'persetujuan_keluarga' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hewan(): BelongsTo
    {
        return $this->belongsTo(Hewan::class);
    }
}
