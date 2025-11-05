<x-layouts.app :title="$game->title">
    <div class="px-6 py-10 bg-gradient-to-b from-gray-900 via-gray-850 to-gray-900 min-h-screen">
        @if(session('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded-lg mb-6 max-w-5xl mx-auto">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 max-w-5xl mx-auto">
                {{ session('info') }}
            </div>
        @endif
        
        <div class="max-w-5xl mx-auto">
            <a href="{{ route('games.index') }}" 
               class="text-indigo-400 hover:text-indigo-300 transition mb-6 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" 
                     stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to all games
            </a>

            <div class="bg-gray-850 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                @if($game->image_url)
                    <img src="{{ asset('storage/' . $game->image_url) }}" 
                         alt="{{ $game->title }}" 
                         class="w-full h-80 object-cover opacity-90 hover:opacity-100 transition duration-300">
                @else
                    <div class="w-full h-80 bg-gray-800 flex items-center justify-center text-gray-500 text-sm">
                        No Image
                    </div>
                @endif

                <div class="p-8">
                    <h1 class="text-4xl font-bold text-indigo-400 mb-4">{{ $game->title }}</h1>

                    <p class="text-gray-400 text-sm mb-3">
                         Developer: <span class="text-gray-300">{{ $game->developer->name ?? 'Unknown' }}</span>
                    </p>

                    <p class="text-gray-300 mb-6 leading-relaxed">{{ $game->description }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-indigo-700/70 text-white px-3 py-1 rounded-full text-sm">
                             {{ number_format($game->rating, 1) }}/10
                        </span>

                        @foreach($game->genres as $genre)
                            <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">{{ $genre->name }}</span>
                        @endforeach

                        @foreach($game->platforms as $platform)
                            <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">{{ $platform->name }}</span>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-700 pt-4 text-sm text-gray-400">
                        <p> Publisher: <span class="text-gray-300">{{ $game->publisher ?? 'Unknown' }}</span></p>
                        <p> Release Date: 
                            <span class="text-gray-300">{{ optional($game->release_date)->format('F j, Y') ?? 'Unknown' }}</span>
                        </p>

                        @if($game->featured)
                            <p class="text-green-400 font-semibold mt-3">🔥 Featured Game!</p>
                        @endif
                    </div>
                    
                    @auth
                        <div class="border-t border-gray-700 pt-6 mt-6">
                            @if($game->isWishlistedBy())
                                <form action="{{ route('wishlist.remove', $game) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-500 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                                        ❤️ Remove from Wishlist
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.add', $game) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-pink-600 hover:bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                                        🤍 Add to Wishlist
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="border-t border-gray-700 pt-6 mt-6">
                            <p class="text-gray-400 text-sm">
                                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Log in</a> 
                                to add games to your wishlist
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
