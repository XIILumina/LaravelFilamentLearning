<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $game->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-8">

    <a href="{{ route('games.index') }}" class="text-indigo-400 hover:text-indigo-300">&larr; Back to all games</a>

    <div class="max-w-3xl mx-auto bg-gray-800 rounded-xl shadow p-6 mt-6">
        @if($game->image)
            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->title }}" class="rounded-lg mb-6 w-full h-72 object-cover">
        @endif

        <h1 class="text-3xl font-bold text-indigo-400 mb-2">{{ $game->title }}</h1>

        <p class="text-gray-400 text-sm mb-4">
            Developer: {{ $game->developer->name ?? 'Unknown' }}
        </p>

        <p class="mb-4 text-gray-300 leading-relaxed">{{ $game->description }}</p>

        <div class="mb-4">
            <span class="bg-indigo-700 px-3 py-1 rounded-full text-sm">⭐ {{ $game->rating }}/10</span>
        </div>

        <p class="mb-2"><strong>Genres:</strong>
            @foreach ($game->genres as $genre)
                <span class="bg-gray-700 px-2 py-1 rounded text-sm">{{ $genre->name }}</span>
            @endforeach
        </p>

        <p><strong>Platforms:</strong>
            @foreach ($game->platforms as $platform)
                <span class="bg-gray-700 px-2 py-1 rounded text-sm">{{ $platform->name }}</span>
            @endforeach
        </p>
    </div>

</body>
</html>
