<x-layouts.app :title="$game->title">
    <div class="px-6 py-8 max-w-4xl mx-auto">
        <a href="{{ route('games.index') }}" class="text-indigo-400 hover:text-indigo-300 mb-4 inline-block">&larr; Back to all games</a>

        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @if($game->image_url)
                <img src="{{ asset('storage/' . $game->image_url) }}" alt="{{ $game->title }}" class="w-full h-72 object-cover">
            @else
                <div class="w-full h-72 bg-gray-700 flex items-center justify-center text-gray-400">
                    No Image
                </div>
            @endif

            <div class="p-6">
                <h1 class="text-4xl font-bold text-indigo-400 mb-4">{{ $game->title }}</h1>
                <p class="text-gray-400 mb-2">Developer: {{ $game->developer->name ?? 'Unknown' }}</p>
                <p class="text-gray-300 mb-4">{{ $game->description }}</p>
                
                <div class="flex flex-wrap gap-3 mb-4">
                    <span class="bg-indigo-700 px-3 py-1 rounded-full text-sm">⭐ {{ number_format($game->rating, 1) }}/10</span>
                    @if($game->genres->count())
                        @foreach($game->genres as $genre)
                            <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $genre->name }}</span>
                        @endforeach
                    @endif
                    @if($game->platforms->count())
                        @foreach($game->platforms as $platform)
                            <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $platform->name }}</span>
                        @endforeach
                    @endif
                </div>

                <p class="text-gray-400 text-sm">Publisher: {{ $game->publisher }}</p>
                <p class="text-gray-400 text-sm">Release Date: {{ $game->release_date->format('F j, Y') }}</p>
                @if($game->featured)
                    <p class="text-green-400 font-semibold mt-2">🔥 Featured Game!</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
