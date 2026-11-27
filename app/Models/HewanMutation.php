<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HewanMutation extends Model
{
    public const DITAMBAHKAN = 'ditambahkan';

    public const DIHAPUS = 'dihapus';

    public const TERADOPSI = 'teradopsi';

    protected $fillable = [
        'hewan_id',
        'nama_hewan',
        'jenis',
        'user_id',
        'keterangan',
    ];

    public function hewan(): BelongsTo
    {
        return $this->belongsTo(Hewan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //
}
