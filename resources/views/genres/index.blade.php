<x-layouts.app title="Browse by Genre">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Browse by Genre</h1>
                <p class="text-zinc-500 text-sm mt-1">Discover games by category</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="px-4 sm:px-6 py-4 border-b border-zinc-800 bg-zinc-900/50">
            <div class="max-w-5xl mx-auto">
                <form method="GET" action="{{ route('genres.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="Search games..." 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                    </div>
                    <select name="genre" 
                            class="sm:w-48 bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-2.5 text-white text-sm focus:ring-2 focus:ring-orange-500">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $selectedGenre == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }} ({{ $genre->games_count }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" 
                            class="bg-orange-500 hover:bg-orange-600 px-5 py-2.5 rounded-xl text-white font-medium text-sm transition">
                        Filter
                    </button>
                </form>
                @if($search || $selectedGenre)
                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-sm text-zinc-500">
                            {{ $games->total() }} result{{ $games->total() !== 1 ? 's' : '' }}
                            @if($search) for "{{ $search }}" @endif
                        </p>
                        <a href="{{ route('genres.index') }}" class="text-sm text-orange-500 hover:text-orange-400">Clear ×</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Games Grid -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-12">
            <div class="max-w-5xl mx-auto">
                @if($games->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                        @foreach($games as $game)
                            <a href="{{ route('games.show', $game) }}" class="group">
                                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden hover:border-zinc-700 transition">
                                    <div class="relative aspect-[3/4]">
                                        @if($game->image_url)
                                            <img src="{{ asset('storage/' . $game->image_url) }}" 
                                                 alt="{{ $game->title }}" 
                                                 class="w-full h-full object-cover group-hover:opacity-90 transition">
                                        @else
                                            <div class="w-full h-full bg-zinc-800 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        @if($game->rating)
                                            <div class="absolute top-2 left-2 flex items-center gap-1 bg-zinc-900/80 backdrop-blur-sm px-2 py-1 rounded-lg">
                                                <svg class="w-3 h-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span class="text-xs font-semibold text-white">{{ number_format((float)($game->rating ?? 0), 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h3 class="font-medium text-white text-sm truncate group-hover:text-orange-500 transition">{{ $game->title }}</h3>
                                        <p class="text-xs text-zinc-500 truncate">{{ $game->developer->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $games->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No games found</h3>
                        <p class="text-zinc-500 text-sm">Try adjusting your search or filters</p>
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
                <a href="{{ route('games.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
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
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app>
