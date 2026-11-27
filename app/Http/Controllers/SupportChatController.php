<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendSupportMessageRequest;
use App\Models\SupportConversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function show(Request $request): View
    {
        $conversation = $request->user()->supportConversation()->first();
        $messages = $conversation?->messages()
            ->with('sender')
            ->latest()
            ->paginate(40);
        $messages?->setCollection($messages->getCollection()->reverse()->values());

        return view('chat.index', [
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function store(SendSupportMessageRequest $request): RedirectResponse
    {
        $conversation = SupportConversation::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $request->validated('message'),
        ]);
        $conversation->touch();

        return redirect()->route('chat.index')->with('success', 'Pesan berhasil dikirim ke admin.');
    }
}
