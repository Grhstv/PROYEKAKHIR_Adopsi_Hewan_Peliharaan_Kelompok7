<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SyaratKetentuanController extends Controller
{
    public function edit(): View
    {
        $terms = TermsAndCondition::query()
            ->where('key', TermsAndCondition::KEY)
            ->first();

        return view('admin.syarat-ketentuan.edit', [
            'terms' => $terms ?? new TermsAndCondition([
                'key' => TermsAndCondition::KEY,
                'content' => TermsAndCondition::DEFAULT_CONTENT,
            ]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:20000'],
        ]);

        $terms = TermsAndCondition::query()->firstOrNew([
            'key' => TermsAndCondition::KEY,
        ]);
        $terms->content = $data['content'];
        $terms->save();

        return redirect()
            ->route('admin.syarat-ketentuan.edit')
            ->with('success', 'Syarat dan ketentuan berhasil diperbarui.');
    }
}
