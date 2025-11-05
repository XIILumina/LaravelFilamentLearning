<x-layouts.app title="Browse Games by Genre">
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-indigo-400 mb-8">Browse Games by Genre</h1>
        
        <!-- Search and Filter Section -->
        <div class="bg-gray-800 rounded-xl p-6 mb-8">
            <form method="GET" action="{{ route('genres.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Games</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Search by title, description, genre, or developer..."
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                
                <!-- Genre Filter -->
                <div class="md:w-64">
                    <label for="genre" class="block text-sm font-medium text-gray-300 mb-2">Filter by Genre</label>
                    <select name="genre" 
                            id="genre"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $selectedGenre == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }} ({{ $genre->games_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Search Button -->
                <div class="md:w-auto md:flex md:items-end">
                    <button type="submit" 
                            class="w-full md:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Filter
                    </button>
                </div>
                
                <!-- Clear Button -->
                @if($search || $selectedGenre)
                    <div class="md:w-auto md:flex md:items-end">
                        <a href="{{ route('genres.index') }}" 
                           class="w-full md:w-auto px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 text-center block">
                            Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Results Summary -->
        @if($search || $selectedGenre)
            <div class="mb-6">
                <p class="text-gray-400">
                    Showing {{ $games->total() }} result{{ $games->total() !== 1 ? 's' : '' }}
                    @if($search)
                        for "{{ $search }}"
                    @endif
                    @if($selectedGenre)
                        @php $currentGenre = $genres->firstWhere('id', $selectedGenre); @endphp
                        in {{ $currentGenre->name ?? 'Unknown Genre' }}
                    @endif
                </p>
            </div>
        @endif

        <!-- Games Grid -->
        @if($games->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
                            
                            <div class="p-4">
                                <h3 class="text-xl font-semibold text-indigo-400 mb-2">{{ $game->title }}</h3>
                                <p class="text-gray-400 text-sm mb-2">{{ $game->developer->name ?? 'Unknown Developer' }}</p>
                                <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ Str::limit($game->description, 100) }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="bg-indigo-700 px-2 py-1 rounded text-xs">⭐ {{ number_format($game->rating, 1) }}</span>
                                    @if($game->featured)
                                        <span class="bg-green-600 px-2 py-1 rounded text-xs">🔥 Featured</span>
                                    @endif
                                </div>
                                
                                <div class="flex flex-wrap gap-1">
                                    @foreach($game->genres->take(3) as $genre)
                                        <span class="bg-gray-700 px-2 py-1 rounded text-xs">{{ $genre->name }}</span>
                                    @endforeach
                                    @if($game->genres->count() > 3)
                                        <span class="text-gray-400 text-xs px-2 py-1">+{{ $game->genres->count() - 3 }} more</span>
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
                <div class="text-gray-400 text-6xl mb-4">🎮</div>
                <h3 class="text-2xl font-semibold text-gray-300 mb-2">No games found</h3>
                <p class="text-gray-400 mb-4">
                    @if($search || $selectedGenre)
                        Try adjusting your search criteria or browse all games.
                    @else
                        No games available at the moment.
                    @endif
                </p>
                @if($search || $selectedGenre)
                    <a href="{{ route('genres.index') }}" 
                       class="inline-block px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        View All Games
                    </a>
                @endif
            </div>
        @endif

        <!-- Genre Statistics -->
        @if(!$search && !$selectedGenre)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-indigo-400 mb-6">Browse by Genre</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($genres as $genre)
                        <a href="{{ route('genres.show', $genre) }}" 
                           class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-white mb-1">{{ $genre->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $genre->games_count }} game{{ $genre->games_count !== 1 ? 's' : '' }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>