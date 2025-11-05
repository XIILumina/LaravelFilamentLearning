<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-8">

    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-400">🎮 Game Database</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($games as $game)
            <div class="bg-gray-800 rounded-xl shadow p-4 hover:shadow-lg transition">
                @if($game->image)
                    <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->title }}" class="rounded-lg mb-4 w-full h-48 object-cover">
                @endif

                <h2 class="text-xl font-semibold text-indigo-300 mb-2">{{ $game->title }}</h2>

                <p class="text-gray-400 text-sm mb-2">Developer: 
                    {{ $game->developer->name ?? 'Unknown' }}
                </p>

                <p class="text-gray-300 mb-3">
                    ⭐ Rating: <strong>{{ $game->rating }}/10</strong>
                </p>

                <a href="{{ route('games.show', $game->id) }}" 
                   class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded text-white font-semibold">
                    View Details
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $games->links() }}
    </div>

</body>
</html>
