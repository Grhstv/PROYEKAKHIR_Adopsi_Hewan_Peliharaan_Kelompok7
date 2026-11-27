<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    public const MENUNGGU = 'menunggu';

    public const DIPROSES = 'diproses';

    public const DIKIRIM = 'dikirim';

    public const SELESAI = 'selesai';

    public const DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'order_number', 'buyer_id', 'shop_id', 'status', 'shipping_address',
        'shipping_phone', 'payment_method', 'note', 'total',
    ];

    protected function casts(): array
    {
        return ['total' => 'decimal:2'];
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
