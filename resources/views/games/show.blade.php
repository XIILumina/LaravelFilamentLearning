<x-layouts.app :title="$game->title">
    <div class="min-h-screen bg-zinc-950">
        <!-- Hero Section with Game Image -->
        <div class="relative">
            @if($game->image_url)
                <div class="h-48 sm:h-64 md:h-80 overflow-hidden">
                    <img src="{{ asset('storage/' . $game->image_url) }}" 
                         alt="{{ $game->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
                </div>
            @else
                <div class="h-48 sm:h-64 md:h-80 bg-gradient-to-br from-orange-600/20 to-zinc-900"></div>
            @endif

            <!-- Back Button -->
            <a href="{{ route('games.index') }}" 
               class="absolute top-4 left-4 bg-zinc-900/80 backdrop-blur-sm text-white p-2 rounded-full hover:bg-zinc-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <!-- Wishlist Button (Top Right) -->
            @auth
                <div class="absolute top-4 right-4">
                    @if($game->isWishlistedBy())
                        <form action="{{ route('wishlist.remove', $game) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-zinc-900/80 backdrop-blur-sm p-2 rounded-full hover:bg-zinc-800 transition">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('wishlist.add', $game) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-zinc-900/80 backdrop-blur-sm p-2 rounded-full hover:bg-zinc-800 transition">
                                <svg class="w-5 h-5 text-zinc-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
        </div>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 -mt-4 relative z-10">
            @if(session('success'))
                <div class="max-w-3xl mx-auto mb-4">
                    <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            
            @if(session('info'))
                <div class="max-w-3xl mx-auto mb-4">
                    <div class="bg-blue-500/20 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl text-sm">
                        {{ session('info') }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 pb-24 sm:pb-12 -mt-16 relative z-10">
            <div class="max-w-3xl mx-auto">
                <!-- Game Info Card -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
                    <div class="p-5 sm:p-6">
                        <!-- Title & Rating -->
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $game->title }}</h1>
                            <div class="flex items-center gap-1 bg-orange-500/20 text-orange-500 px-3 py-1.5 rounded-full text-sm font-semibold shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format((float)($game->rating ?? 0), 1) }}
                            </div>
                        </div>

                        <!-- Developer -->
                        <p class="text-zinc-400 text-sm mb-4">
                            by <span class="text-zinc-300">{{ $game->developer->name ?? 'Unknown Developer' }}</span>
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($game->genres as $genre)
                                <span class="bg-zinc-800 text-zinc-300 px-3 py-1 rounded-full text-xs">{{ $genre->name }}</span>
                            @endforeach
                            @foreach($game->platforms as $platform)
                                <span class="bg-zinc-800/60 text-zinc-400 px-3 py-1 rounded-full text-xs">{{ $platform->name }}</span>
                            @endforeach
                        </div>

                        <!-- Description -->
                        <div class="border-t border-zinc-800 pt-5 mb-5">
                            <h2 class="text-sm font-medium text-zinc-400 mb-2">About</h2>
                            <p class="text-zinc-300 leading-relaxed">{{ $game->description }}</p>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4 border-t border-zinc-800 pt-5">
                            <div>
                                <span class="text-xs text-zinc-500 block mb-1">Publisher</span>
                                <span class="text-sm text-zinc-300">{{ $game->publisher ?? 'Unknown' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-zinc-500 block mb-1">Release Date</span>
                                <span class="text-sm text-zinc-300">{{ optional($game->release_date)->format('M j, Y') ?? 'Unknown' }}</span>
                            </div>
                        </div>

                        @if($game->featured)
                            <div class="mt-5 pt-5 border-t border-zinc-800">
                                <span class="inline-flex items-center gap-2 bg-orange-500/10 text-orange-500 px-3 py-2 rounded-lg text-sm font-medium">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"/>
                                    </svg>
                                    Featured Game
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Actions Footer -->
                    @auth
                        <div class="bg-zinc-900/50 border-t border-zinc-800 p-5 sm:p-6">
                            <div class="flex flex-col sm:flex-row gap-3">
                                @if($game->isWishlistedBy())
                                    <form action="{{ route('wishlist.remove', $game) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-500 px-6 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            Remove from Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $game) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            Add to Wishlist
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-zinc-900/50 border-t border-zinc-800 p-5 sm:p-6">
                            <p class="text-center text-zinc-400 text-sm">
                                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-400 font-medium">Log in</a> 
                                to add games to your wishlist
                            </p>
                        </div>
                    @endauth
                </div>

                <!-- Related Community Section -->
                @if($game->community)
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-white mb-3">Community</h2>
                        <a href="{{ route('communities.show', $game->community) }}" 
                           class="block bg-zinc-900 border border-zinc-800 rounded-2xl p-4 hover:border-zinc-700 transition group">
                            <div class="flex items-center gap-3">
                                @if($game->community->icon_url)
                                    <img src="{{ $game->community->icon_url }}" 
                                         alt="{{ $game->community->name }}" 
                                         class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 bg-zinc-800 rounded-full flex items-center justify-center">
                                        <span class="text-xl">🎮</span>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-white group-hover:text-orange-500 transition">{{ $game->community->name }}</h3>
                                    <p class="text-sm text-zinc-500">{{ number_format($game->community->subscriber_count ?? 0) }} members</p>
                                </div>
                                <svg class="w-5 h-5 text-zinc-600 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-zinc-900/95 backdrop-blur-lg border-t border-zinc-800 sm:hidden z-50">
            <div class="flex items-center justify-around py-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="{{ route('games.index') }}" class="flex flex-col items-center p-2 text-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 6H3a1 1 0 00-1 1v10a1 1 0 001 1h18a1 1 0 001-1V7a1 1 0 00-1-1zm-1 10H4V8h16v8zM6 9h2v2H6V9zm0 3h2v2H6v-2zm3-3h2v2H9V9zm0 3h2v2H9v-2zm3-3h6v2h-6V9zm0 3h6v2h-6v-2z"/>
                    </svg>
                    <span class="text-xs mt-1">Games</span>
                </a>
                <a href="{{ route('communities.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Communities</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-xs mt-1">Profile</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-xs mt-1">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app>
