<x-layouts.app :title="'Game Database'">
    <div class="px-6 py-8">
        <h1 class="text-4xl font-bold text-indigo-400 mb-8 text-center">🎮 Game Database</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($games as $game)
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                    @if($game->image_url)
                        <img src="{{ asset('storage/' . $game->image_url) }}" alt="{{ $game->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-indigo-300 mb-2">{{ $game->title }}</h2>
                        <p class="text-gray-400 text-sm mb-2">Developer: {{ $game->developer->name ?? 'Unknown' }}</p>
                        <p class="text-gray-300 mb-3">⭐ Rating: <strong>{{ number_format($game->rating, 1) }}/10</strong></p>
                        
                        <p class="text-gray-300 mb-3 text-sm">
                            Genres: {{ $game->genres->pluck('name')->join(', ') ?: 'N/A' }}
                        </p>
                        <p class="text-gray-300 mb-3 text-sm">
                            Platforms: {{ $game->platforms->pluck('name')->join(', ') ?: 'N/A' }}
                        </p>

                        <a href="{{ route('games.show', $game->id) }}" 
                           class="inline-block mt-2 w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded text-white font-semibold">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $games->links() }}
        </div>
    </div>
</x-layouts.app>
