<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = ['nama', 'slug'];

    public function hewans(): HasMany
    {
        return $this->hasMany(Hewan::class);
    }
}
