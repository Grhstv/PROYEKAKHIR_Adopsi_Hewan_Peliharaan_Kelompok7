<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request): View
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->withCount(['messages as unread_count' => fn ($query) => $query
                ->where('sender_id', '!=', $request->user()->id)
                ->whereNull('read_at')])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('admin.chat.index', compact('conversations'));
    }

    public function show(Request $request, Conversation $conversation): View
    {
        $conversation->load('user');
        $conversation->messages()
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        $messages = $conversation->messages()->with('sender')->oldest()->get();

        return view('admin.chat.show', compact('conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'min:1', 'max:2000']]);
        $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);
        $conversation->update(['last_message_at' => now()]);

        return back()->with('success', 'Pesan terkirim kepada '.$conversation->user->name.'.');
    }

    public function broadcast(Request $request): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'min:1', 'max:2000']]);
        $adminId = $request->user()->id;
        $recipientCount = 0;

        DB::transaction(function () use ($data, $adminId, &$recipientCount): void {
            User::query()
                ->whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['admin', 'petugas']))
                ->chunkById(100, function ($users) use ($data, $adminId, &$recipientCount): void {
                    foreach ($users as $user) {
                        $conversation = $user->conversation()->firstOrCreate([]);
                        $conversation->messages()->create([
                            'sender_id' => $adminId,
                            'body' => $data['body'],
                        ]);
                        $conversation->update(['last_message_at' => now()]);
                        $recipientCount++;
                    }
                });
        });

        if ($recipientCount === 0) {
            return back()->with('error', 'Belum ada pengguna yang dapat menerima pengumuman.');
        }

        return back()->with('success', "Pengumuman terkirim kepada {$recipientCount} pengguna.");
    }
}
