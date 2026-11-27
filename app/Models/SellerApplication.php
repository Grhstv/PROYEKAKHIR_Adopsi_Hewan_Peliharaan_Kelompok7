<?php

namespace App\Models;

use Database\Factories\SellerApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerApplication extends Model
{
    /** @use HasFactory<SellerApplicationFactory> */
    use HasFactory;

    public const MENUNGGU = 'menunggu';

    public const DISETUJUI = 'disetujui';

    public const DITOLAK = 'ditolak';

    protected $fillable = [
        'user_id', 'store_name', 'store_description', 'address', 'phone',
        'status', 'admin_note', 'processed_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
