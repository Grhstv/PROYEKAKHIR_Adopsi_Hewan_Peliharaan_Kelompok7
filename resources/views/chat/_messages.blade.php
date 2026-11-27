@foreach ($messages as $message)
    @php($isOwnMessage = $message->sender_id === auth()->id())
    <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
        <div class="max-w-[88%] rounded-2xl px-4 py-3 sm:max-w-[75%] {{ $isOwnMessage ? 'rounded-br-md bg-[#365b45] text-white' : 'rounded-bl-md border border-[#e7e9e1] bg-white text-[#33483a]' }}">
            <div class="mb-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] {{ $isOwnMessage ? 'text-white/75' : 'text-[#899389]' }}">
                <span class="font-semibold">{{ $isOwnMessage ? 'Anda' : $otherSenderName }}</span>
                <time datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('d/m/Y H:i') }}</time>
            </div>
            <p class="whitespace-pre-line break-words text-sm leading-6">{{ $message->body }}</p>
        </div>
    </div>
@endforeach
