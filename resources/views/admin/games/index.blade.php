<x-layouts.app :title="'Manage Games'">
    <div class="w-full px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Game Management</h1>
                <p class="text-slate-600 dark:text-slate-400">Edit and manage game information</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6 mb-6">
                <form method="GET" action="{{ route('admin.games') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" placeholder="Search games..." value="{{ request('search') }}" 
                           class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                    <select name="genre" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" @if(request('genre') == $genre->id) selected @endif>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Search
                    </button>
                </form>
            </div>

            <!-- Games Table -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Developer</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Rating</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Genres</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($games as $game)
                            <tr class="border-t border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-900 dark:text-white font-medium">{{ $game->title }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $game->developer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        {{ number_format((float)$game->rating, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $game->genres->pluck('name')->join(', ') ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.games.edit', $game) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-600 dark:text-slate-400">
                                    No games found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($games->hasPages())
                <div class="mt-6">
                    {{ $games->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
