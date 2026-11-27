<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request): View
    {
        $conversation = $request->user()->conversation()->firstOrCreate([]);
        $conversation->messages()
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        $messages = $conversation->messages()->with('sender')->oldest()->get();

        return view('chat.index', compact('conversation', 'messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:2000'],
        ]);
        $conversation = $request->user()->conversation()->firstOrCreate([]);
        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);
        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('chat.index')->with('success', 'Pesan terkirim.');
    }
}
