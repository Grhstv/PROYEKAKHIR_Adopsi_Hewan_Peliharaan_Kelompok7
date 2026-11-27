<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use Illuminate\Contracts\View\View;

class SyaratKetentuanController extends Controller
{
    public function show(): View
    {
        $terms = TermsAndCondition::query()
            ->where('key', TermsAndCondition::KEY)
            ->first();

        return view('syarat-ketentuan.show', [
            'content' => $terms?->content ?? TermsAndCondition::DEFAULT_CONTENT,
            'updatedAt' => $terms?->updated_at,
        ]);
    }
}
