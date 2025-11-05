<x-layouts.app title="My Wishlist">
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-indigo-400 mb-8">My Wishlist</h1>
        
        @if(session('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6">
                {{ session('info') }}
            </div>
        @endif

        @if($games->count() > 0)
            <p class="text-gray-400 mb-6">{{ $games->count() }} game{{ $games->count() !== 1 ? 's' : '' }} in your wishlist</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($games as $game)
                    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-200">
                        <a href="{{ route('games.show', $game) }}" class="block">
                            @if($game->image_url)
                                <img src="{{ asset('storage/' . $game->image_url) }}" 
                                     alt="{{ $game->title }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-indigo-400 mb-2">
                                <a href="{{ route('games.show', $game) }}" class="hover:text-indigo-300">{{ $game->title }}</a>
                            </h3>
                            <p class="text-gray-400 text-sm mb-2">{{ $game->developer->name ?? 'Unknown Developer' }}</p>
                            <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ Str::limit($game->description, 100) }}</p>
                            
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="bg-indigo-700 px-2 py-1 rounded text-xs">⭐ {{ number_format($game->rating, 1) }}</span>
                                @if($game->featured)
                                    <span class="bg-green-600 px-2 py-1 rounded text-xs">🔥 Featured</span>
                                @endif
                                <span class="bg-gray-600 px-2 py-1 rounded text-xs">{{ optional($game->release_date)->format('Y') }}</span>
                            </div>
                            
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($game->genres->take(3) as $genre)
                                    <span class="bg-gray-700 px-2 py-1 rounded text-xs">{{ $genre->name }}</span>
                                @endforeach
                                @if($game->genres->count() > 3)
                                    <span class="text-gray-400 text-xs px-2 py-1">+{{ $game->genres->count() - 3 }} more</span>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <a href="{{ route('games.show', $game) }}" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm transition-colors duration-200">
                                    View Details
                                </a>
                                
                                <form action="{{ route('wishlist.remove', $game) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-colors duration-200"
                                            onclick="return confirm('Remove {{ $game->title }} from your wishlist?')">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">❤️</div>
                <h3 class="text-2xl font-semibold text-gray-300 mb-2">Your wishlist is empty</h3>
                <p class="text-gray-400 mb-6">Start adding games you want to play!</p>
                <a href="{{ route('games.index') }}" 
                   class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                    Browse Games
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>