<x-layouts.app :title="__('Connections')">
    <div class="min-h-screen pb-96">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800/50">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1">
                    Connections 🤝
                </h1>
                <p class="text-zinc-400 text-sm sm:text-base">
                    Connect with friends and fellow gamers
                </p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            <!-- Tabs -->
            <div x-data="{ activeTab: 'friends' }" class="mb-6">
                <div class="border-b border-zinc-800/50">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'friends'" 
                                :class="activeTab === 'friends' ? 'border-orange-500 text-orange-500' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Friends
                            <span class="ml-2 bg-zinc-800 text-zinc-300 py-0.5 px-2 rounded-full text-xs">
                                {{ auth()->user()->friends()->count() }}
                            </span>
                        </button>
                        <button @click="activeTab = 'requests'" 
                                :class="activeTab === 'requests' ? 'border-orange-500 text-orange-500' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Requests
                            @if(auth()->user()->pendingFriendRequests()->count() > 0)
                                <span class="ml-2 bg-orange-600 text-white py-0.5 px-2 rounded-full text-xs font-semibold">
                                    {{ auth()->user()->pendingFriendRequests()->count() }}
                                </span>
                            @else
                                <span class="ml-2 bg-zinc-800 text-zinc-300 py-0.5 px-2 rounded-full text-xs">
                                    0
                                </span>
                            @endif
                        </button>
                        <button @click="activeTab = 'find'" 
                                :class="activeTab === 'find' ? 'border-orange-500 text-orange-500' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Find Friends
                        </button>
                    </nav>
                </div>

                <!-- Friends List -->
                <div x-show="activeTab === 'friends'" class="mt-6">
                    @php
                        $friends = auth()->user()->friends();
                    @endphp

                    @if($friends->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($friends as $friend)
                                <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4 hover:border-zinc-600/50 transition-colors">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 bg-zinc-700 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ $friend->initials() }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-white">{{ $friend->name }}</h3>
                                            <p class="text-sm text-zinc-500">@<span>{{ $friend->username ?? 'user' }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('messages.show', $friend) }}" 
                                           class="flex-1 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium py-2 rounded-lg transition-colors text-center">
                                            Message
                                        </a>
                                        <form method="POST" action="{{ route('connections.unfriend', $friend) }}" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to unfriend {{ $friend->name }}?')"
                                                    class="w-full bg-zinc-700 hover:bg-zinc-600 text-white text-sm font-medium py-2 rounded-lg transition-colors">
                                                Unfriend
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">👥</div>
                            <h3 class="text-xl font-semibold text-white mb-2">No friends yet</h3>
                            <p class="text-zinc-400 mb-6">Start connecting with other gamers to grow your network!</p>
                            <button @click="activeTab = 'find'" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-6 py-2 rounded-lg transition-colors">
                                Find Friends
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Friend Requests -->
                <div x-show="activeTab === 'requests'" style="display: none;" class="mt-6">
                    @php
                        $requests = auth()->user()->pendingFriendRequests()->with('user')->get();
                    @endphp

                    @if($requests->count() > 0)
                        <div class="space-y-4">
                            @foreach($requests as $request)
                                <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-zinc-700 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ $request->user->initials() }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-white">{{ $request->user->name }}</h3>
                                            <p class="text-sm text-zinc-500">@<span>{{ $request->user->username ?? 'user' }}</span></p>
                                            <p class="text-xs text-zinc-600 mt-1">{{ $request->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('connections.accept', $request->user) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                                                Accept
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('connections.decline', $request->user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-zinc-700 hover:bg-zinc-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📬</div>
                            <h3 class="text-xl font-semibold text-white mb-2">No pending requests</h3>
                            <p class="text-zinc-400">You're all caught up!</p>
                        </div>
                    @endif
                </div>

                <!-- Find Friends -->
                <div x-show="activeTab === 'find'" style="display: none;" class="mt-6">
                    @php
                        $suggestedUsers = \App\Models\User::where('id', '!=', auth()->id())
                            ->whereNotIn('id', auth()->user()->friends()->pluck('id'))
                            ->inRandomOrder()
                            ->limit(12)
                            ->get();
                    @endphp

                    @if($suggestedUsers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($suggestedUsers as $user)
                                <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4 hover:border-zinc-600/50 transition-colors">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 bg-zinc-700 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ $user->initials() }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-white">{{ $user->name }}</h3>
                                            <p class="text-sm text-zinc-500">@<span>{{ $user->username ?? 'user' }}</span></p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('connections.request', $user) }}">
                                        @csrf
                                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium py-2 rounded-lg transition-colors">
                                            Add Friend
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎉</div>
                            <h3 class="text-xl font-semibold text-white mb-2">You've found everyone!</h3>
                            <p class="text-zinc-400">Check back later for more users to connect with.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app>
