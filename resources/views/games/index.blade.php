<x-layouts.app :title="'Games'">
    <div class="min-h-screen pb-96">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800/50">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1">Games</h1>
                <p class="text-zinc-400 text-sm sm:text-base">Discover and explore our game collection</p>
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl mb-4 text-sm">
                    {{ session('info') }}
                </div>
            @endif
        </div>

        <!-- Games Grid -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                @foreach ($games as $game)
                    <div class="group">
                        <!-- Game Card -->
                        <a href="{{ route('games.show', $game->id) }}" class="block">
                            <div class="aspect-[3/4] rounded-xl overflow-hidden bg-zinc-800 mb-2 relative">
                                @if($game->image_url)
                                    <img src="{{ asset('storage/' . $game->image_url) }}" 
                                         alt="{{ $game->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-4xl opacity-30">🎮</span>
                                    </div>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="absolute top-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
                                    <span class="text-yellow-500 text-xs">★</span>
                                    <span class="text-white text-xs font-medium">{{ number_format((float)($game->rating ?? 0), 1) }}</span>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Game Info -->
                        <div class="space-y-1">
                            <a href="{{ route('games.show', $game->id) }}">
                                <h2 class="font-medium text-white text-sm group-hover:text-orange-400 transition-colors line-clamp-1">
                                    {{ $game->title }}
                                </h2>
                            </a>
                            <p class="text-xs text-zinc-500 line-clamp-1">
                                {{ $game->developer->name ?? 'Unknown' }}
                            </p>
                            
                            <!-- Genres -->
                            @if($game->genres->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($game->genres->take(2) as $genre)
                                        <span class="text-[10px] px-1.5 py-0.5 bg-zinc-800 text-zinc-400 rounded">
                                            {{ $genre->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <!-- Actions -->
                            <div class="flex gap-2 pt-2">
                                <a href="{{ route('games.show', $game->id) }}" 
                                   class="flex-1 text-center px-2 py-1.5 bg-orange-500 hover:bg-orange-600 rounded-lg text-white text-xs font-medium transition-colors">
                                    View
                                </a>
                                
                                @auth
                                    @if($game->isWishlistedBy())
                                        <form action="{{ route('wishlist.remove', $game) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 bg-pink-500/20 hover:bg-pink-500/30 rounded-lg text-pink-400 transition-colors"
                                                    title="Remove from wishlist">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', $game) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-1.5 bg-zinc-800 hover:bg-pink-500/20 rounded-lg text-zinc-400 hover:text-pink-400 transition-colors border border-zinc-700"
                                                    title="Add to wishlist">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $games->links() }}
            </div>
        </div>
    </div>
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app>
