<x-layouts.app title="Messages">
    <div class="min-h-screen bg-zinc-950 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Messages
                </h1>
                <p class="text-zinc-400 mt-2">Chat with other members</p>
            </div>

            @if($conversations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($conversations as $conversationUser)
                        <a href="{{ route('messages.show', $conversationUser) }}" 
                           class="bg-zinc-900 rounded-lg p-6 hover:bg-zinc-800 transition-all hover:scale-105 border border-zinc-800 hover:border-orange-500/50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-zinc-800 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ $conversationUser->initials() }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-white truncate">{{ $conversationUser->name }}</h3>
                                    @if($conversationUser->username)
                                        <p class="text-sm text-zinc-400">@{{ $conversationUser->username }}</p>
                                    @else
                                        <p class="text-sm text-zinc-400">{{ $conversationUser->email }}</p>
                                    @endif
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-zinc-900 rounded-lg p-12 text-center border border-zinc-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">No conversations yet</h3>
                    <p class="text-zinc-400 mb-6">Start chatting with other members to see your conversations here</p>
                    <a href="{{ route('communities.index') }}" 
                       class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                        Explore Communities
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
