<x-layouts.app :title="'Game Database'">
    <div class="px-6 py-10 bg-gradient-to-b from-zinc-900 via-zinc-850 to-zinc-900 min-h-screen">
        @if(session('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded-lg mb-6 max-w-4xl mx-auto">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 max-w-4xl mx-auto">
                {{ session('info') }}
            </div>
        @endif
          -0
        <h1 class="text-5xl font-extrabold text-center text-indigo-400 mb-12 tracking-wide drop-shadow-lg">
            🎮 Game Database
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($games as $game)
                <div class="bg-zinc-850 border border-zinc-700 rounded-2xl shadow-xl overflow-hidden 
                            hover:scale-[1.03] hover:shadow-indigo-900/30 transition-all duration-300">
                    @if($game->image_url)
                        <img src="{{ asset('storage/' . $game->image_url) }}" 
                             alt="{{ $game->title }}" 
                             class="w-full h-56 object-cover opacity-90 hover:opacity-100 transition duration-300">
                    @else
                        <div class="w-full h-56 bg-zinc-800 flex items-center justify-center text-zinc-500 text-sm">
                            No Image
                        </div>
                    @endif

                    <div class="p-5">
                        <h2 class="text-2xl font-semibold text-indigo-300 mb-3">{{ $game->title }}</h2>
-6
                        <p class="text-zinc-400 text-sm mb-1"> Developer: 
                            <span class="text-zinc-300">{{ $game->developer->name ?? 'Unknown' }}</span>
                        </p>
                        <p class="text-zinc-400 text-sm mb-2"> Rating: 
                            <span class="font-bold text-indigo-400">{{ number_format($game->rating, 1) }}/10</span>
                        </p>

                        <div class="text-sm text-zinc-400 mb-3">
                             Genres: 
                            <span class="text-zinc-300">{{ $game->genres->pluck('name')->join(', ') ?: 'N/A' }}</span>
                        </div>
                        <div class="text-sm text-zinc-400 mb-4">
                             Platforms: 
                            <span class="text-zinc-300">{{ $game->platforms->pluck('name')->join(', ') ?: 'N/A' }}</span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('games.show', $game->id) }}" 
                               class="flex-1 text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg 
                                      text-white font-semibold tracking-wide transition duration-200">
                                View Details
                            </a>
                            
                            @auth
                                @if($game->isWishlistedBy())
                                    <form action="{{ route('wishlist.remove', $game) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition duration-200"
                                                title="Remove from wishlist">
                                            ❤️
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $game) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-2 bg-zinc-600 hover:bg-pink-600 rounded-lg text-white transition duration-200"
                                                title="Add to wishlist">
                                            🤍
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $games->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.app>
