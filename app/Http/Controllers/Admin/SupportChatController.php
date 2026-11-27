<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendSupportMessageRequest;
use App\Models\SupportConversation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SupportChatController extends Controller
{
    public function index(): View
    {
        $conversations = SupportConversation::with('user')
            ->withCount('messages')
            ->latest('updated_at')
            ->paginate(20);

        return view('admin.chat.index', compact('conversations'));
    }

    public function show(SupportConversation $conversation): View
    {
        $conversation->load('user');
        $messages = $conversation->messages()
            ->with('sender')
            ->latest()
            ->paginate(40);
        $messages->setCollection($messages->getCollection()->reverse()->values());

        return view('admin.chat.show', [
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function store(SendSupportMessageRequest $request, SupportConversation $conversation): RedirectResponse
    {
        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $request->validated('message'),
        ]);
        $conversation->touch();

        return redirect()->route('admin.chat.show', $conversation)->with('success', 'Balasan berhasil dikirim.');
    }
}
