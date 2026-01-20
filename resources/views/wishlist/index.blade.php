<x-layouts.app title="My Wishlist">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-red-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">My Wishlist</h1>
                </div>
                @if($games->count() > 0)
                    <p class="text-zinc-500 text-sm">{{ $games->count() }} game{{ $games->count() !== 1 ? 's' : '' }} saved</p>
                @endif
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="px-4 sm:px-6 pt-4">
            <div class="max-w-4xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="bg-blue-500/20 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl text-sm mb-4">
                        {{ session('info') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-12">
            <div class="max-w-4xl mx-auto">
                @if($games->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        @foreach($games as $game)
                            <div class="group bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden hover:border-zinc-700 transition">
                                <!-- Game Image -->
                                <a href="{{ route('games.show', $game) }}" class="block relative aspect-[3/4]">
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

                                    <!-- Rating Badge -->
                                    @if($game->rating)
                                        <div class="absolute top-2 left-2 flex items-center gap-1 bg-zinc-900/80 backdrop-blur-sm px-2 py-1 rounded-lg">
                                            <svg class="w-3 h-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-xs font-semibold text-white">{{ number_format((float)($game->rating ?? 0), 1) }}</span>
                                        </div>
                                    @endif

                                    <!-- Remove Button -->
                                    <form action="{{ route('wishlist.remove', $game) }}" method="POST" 
                                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500/80 hover:bg-red-500 backdrop-blur-sm p-1.5 rounded-lg transition"
                                                onclick="return confirm('Remove {{ $game->title }} from your wishlist?')">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </a>
                                
                                <!-- Game Info -->
                                <div class="p-3">
                                    <h3 class="font-medium text-white text-sm truncate group-hover:text-orange-500 transition">
                                        <a href="{{ route('games.show', $game) }}">{{ $game->title }}</a>
                                    </h3>
                                    <p class="text-xs text-zinc-500 truncate">{{ $game->developer->name ?? 'Unknown' }}</p>
                                    
                                    <!-- Genre Tags -->
                                    @if($game->genres->count() > 0)
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach($game->genres->take(2) as $genre)
                                                <span class="text-[10px] bg-zinc-800 text-zinc-400 px-2 py-0.5 rounded-full">{{ $genre->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Your wishlist is empty</h3>
                        <p class="text-zinc-500 text-sm mb-6">Start adding games you want to play!</p>
                        <a href="{{ route('games.index') }}" 
                           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            </svg>
                            Browse Games
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
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 text-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-xs mt-1">Profile</span>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
