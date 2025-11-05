<x-layouts.app :title="$genre->name . ' Games'">
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('genres.index') }}" class="text-indigo-400 hover:text-indigo-300 mb-4 inline-block">&larr; Back to all genres</a>
            <h1 class="text-4xl font-bold text-indigo-400 mb-2">{{ $genre->name }} Games</h1>
            <p class="text-zinc-400">{{ $games->total() }} game{{ $games->total() !== 1 ? 's' : '' }} found</p>
        </div>
        
        <!-- Search Section -->
        <div class="bg-zinc-800 rounded-xl p-6 mb-8">
            <form method="GET" action="{{ route('genres.show', $genre) }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-zinc-300 mb-2">Search in {{ $genre->name }}</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Search by title, description, or developer..."
                           class="w-full px-4 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                
                <!-- Search Button -->
                <div class="md:w-auto md:flex md:items-end">
                    <button type="submit" 
                            class="w-full md:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Search
                    </button>
                </div>
                
                <!-- Clear Button -->
                @if($search)
                    <div class="md:w-auto md:flex md:items-end">
                        <a href="{{ route('genres.show', $genre) }}" 
                           class="w-full md:w-auto px-6 py-2 bg-zinc-600 hover:bg-zinc-700 text-white font-medium rounded-lg transition-colors duration-200 text-center block">
                            Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Results Summary -->
        @if($search)
            <div class="mb-6">
                <p class="text-zinc-400">
                    Showing {{ $games->total() }} result{{ $games->total() !== 1 ? 's' : '' }} for "{{ $search }}" in {{ $genre->name }}
                </p>
            </div>
        @endif

        <!-- Games Grid -->
        @if($games->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($games as $game)
                    <div class="bg-zinc-800 rounded-xl shadow-lg overflow-hidden hover:transform hover:scale-105 transition-all duration-200">
                        <a href="{{ route('games.show', $game) }}" class="block">
                            @if($game->image_url)
                                <img src="{{ asset('storage/' . $game->image_url) }}" 
                                     alt="{{ $game->title }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-zinc-700 flex items-center justify-center text-zinc-400">
                                    No Image
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="text-xl font-semibold text-indigo-400 mb-2">{{ $game->title }}</h3>
                                <p class="text-zinc-400 text-sm mb-2">{{ $game->developer->name ?? 'Unknown Developer' }}</p>
                                <p class="text-zinc-300 text-sm mb-3 line-clamp-2">{{ Str::limit($game->description, 100) }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="bg-indigo-700 px-2 py-1 rounded text-xs">⭐ {{ number_format($game->rating, 1) }}</span>
                                    @if($game->featured)
                                        <span class="bg-green-600 px-2 py-1 rounded text-xs">🔥 Featured</span>
                                    @endif
                                    <span class="bg-yellow-600 px-2 py-1 rounded text-xs">{{ $genre->name }}</span>
                                </div>
                                
                                <div class="flex flex-wrap gap-1">
                                    @foreach($game->genres->where('id', '!=', $genre->id)->take(2) as $otherGenre)
                                        <span class="bg-zinc-700 px-2 py-1 rounded text-xs">{{ $otherGenre->name }}</span>
                                    @endforeach
                                </div>
                                
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($game->platforms->take(3) as $platform)
                                        <span class="bg-blue-700 px-2 py-1 rounded text-xs">{{ $platform->name }}</span>
                                    @endforeach
                                    @if($game->platforms->count() > 3)
                                        <span class="text-zinc-400 text-xs px-2 py-1">+{{ $game->platforms->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $games->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-12">
                <div class="text-zinc-400 text-6xl mb-4">🎮</div>
                <h3 class="text-2xl font-semibold text-zinc-300 mb-2">No games found</h3>
                <p class="text-zinc-400 mb-4">
                    @if($search)
                        No games found for "{{ $search }}" in {{ $genre->name }}. Try a different search term.
                    @else
                        No games available in the {{ $genre->name }} genre yet.
                    @endif
                </p>
                @if($search)
                    <a href="{{ route('genres.show', $genre) }}" 
                       class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        View All {{ $genre->name }} Games
                    </a>
                @else
                    <a href="{{ route('genres.index') }}" 
                       class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Browse Other Genres
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-layouts.app>