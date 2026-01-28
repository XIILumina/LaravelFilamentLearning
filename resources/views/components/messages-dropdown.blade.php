<!-- Messages Dropdown -->
<div x-data="{ open: false, buttonRect: null }" class="relative" @click.away="open = false">
    <button @click="open = !open; buttonRect = $el.getBoundingClientRect()" class="relative p-2 text-zinc-400 hover:text-white rounded-lg hover:bg-zinc-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        @php
            $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
        @endphp
        @if($unreadMessages > 0)
            <span class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-green-600 text-white text-xs font-bold">
                {{ $unreadMessages > 9 ? '9+' : $unreadMessages }}
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed w-96 origin-top-left rounded-lg bg-zinc-900 shadow-xl ring-1 ring-zinc-800 z-[100]"
         :style="buttonRect ? `top: ${buttonRect.bottom + 8}px; left: ${buttonRect.left}px;` : 'display: none;'"
         style="display: none;">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-800">
            <h3 class="text-lg font-semibold text-white">Messages</h3>
        </div>

        <!-- Messages List -->
        <div class="max-h-96 overflow-y-auto">
            @php
                $recentMessages = \App\Models\Message::where(function($query) {
                    $query->where('sender_id', auth()->id())
                          ->orWhere('receiver_id', auth()->id());
                })
                ->with(['sender', 'receiver'])
                ->latest()
                ->take(8)
                ->get()
                ->unique(function ($message) {
                    $otherUserId = $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id;
                    return $otherUserId;
                });
            @endphp

            @forelse($recentMessages as $message)
                @php
                    $otherUser = $message->sender_id === auth()->id() ? $message->receiver : $message->sender;
                    $isUnread = $message->receiver_id === auth()->id() && !$message->is_read;
                @endphp
                <a href="{{ route('messages.show', $otherUser) }}" 
                   class="block px-4 py-3 hover:bg-zinc-800 transition-colors border-b border-zinc-800/50 {{ $isUnread ? 'bg-zinc-850/50' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-zinc-800 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ $otherUser->initials() }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white {{ $isUnread ? 'font-semibold' : '' }}">
                                {{ $otherUser->name }}
                            </p>
                            <p class="text-xs text-zinc-400 truncate">
                                {{ $message->sender_id === auth()->id() ? 'You: ' : '' }}{{ Str::limit($message->message, 30) }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-end gap-1">
                            <p class="text-xs text-zinc-500">{{ $message->created_at->diffForHumans(null, true) }}</p>
                            @if($isUnread)
                                <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-zinc-700 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-sm text-zinc-500">No messages yet</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-zinc-850 border-t border-zinc-800 rounded-b-lg">
            <a href="{{ route('messages.index') }}" class="text-sm text-green-500 hover:text-green-400 font-medium">
                View all messages →
            </a>
        </div>
    </div>
</div>
