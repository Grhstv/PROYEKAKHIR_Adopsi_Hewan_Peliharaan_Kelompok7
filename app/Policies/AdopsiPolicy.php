<?php

namespace App\Policies;

use App\Models\Adopsi;
use App\Models\User;

class AdopsiPolicy
{
    /** Hanya pemilik pengajuan yang boleh membatalkan, dan hanya saat masih menunggu (pencegah IDOR). */
    public function cancel(User $user, Adopsi $adopsi): bool
    {
        return $user->id === $adopsi->user_id && $adopsi->status === Adopsi::MENUNGGU;
    }
}
