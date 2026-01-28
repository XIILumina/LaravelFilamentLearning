<x-layouts.app :title="'Chat with ' . $user->name">
    <div class="min-h-screen bg-zinc-950 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button & User Header -->
            <div class="mb-6">
                <a href="{{ route('messages.index') }}" 
                   class="inline-flex items-center gap-2 text-zinc-400 hover:text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Messages
                </a>

                <div class="bg-zinc-900 rounded-lg p-4 border border-zinc-800">
                    <div class="flex items-center gap-4">
                        <x-avatar :user="$user" size="lg" />
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                            @if($user->username)
                                <p class="text-zinc-400">@{{ $user->username }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="bg-zinc-900 rounded-lg border border-zinc-800 flex flex-col" style="height: 600px;">
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
                    @forelse($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-md">
                                <div class="flex items-end gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                    <x-avatar :user="$message->sender" size="sm" class="flex-shrink-0" />
                                    <div>
                                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-orange-600 text-white' : 'bg-zinc-800 text-white' }}">
                                            <p class="break-words">{{ $message->message }}</p>
                                        </div>
                                        <p class="text-xs text-zinc-500 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <p class="text-zinc-500 mb-2">No messages yet</p>
                                <p class="text-zinc-600 text-sm">Start the conversation below</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="border-t border-zinc-800 p-4">
                    <form action="{{ route('messages.store', $user) }}" method="POST" class="flex gap-2">
                        @csrf
                        <textarea 
                            name="message" 
                            rows="2"
                            placeholder="Type your message..."
                            required
                            class="flex-1 bg-zinc-800 border border-zinc-700 rounded-lg px-4 py-2 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                        ></textarea>
                        <button 
                            type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2 self-end">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Send
                        </button>
                    </form>
                    @error('message')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    @if($messages->count() > 0)
    <script>
        // Scroll to bottom of messages on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        });
    </script>
    @endif
</x-layouts.app>
