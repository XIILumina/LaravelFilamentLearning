<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-indigo-100">Discover and manage your favorite games in your personal database.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Games</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Game::count() }}</p>
                    </div>
                    <div class="bg-indigo-600 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">My Wishlist</p>
                        <p class="text-2xl font-bold text-white">{{ auth()->user()->wishlistGames()->count() }}</p>
                    </div>
                    <div class="bg-pink-600 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Genres</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Genre::count() }}</p>
                    </div>
                    <div class="bg-green-600 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Recent Wishlist -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-4">Recent Wishlist Items</h2>
                @php
                    $recentWishlist = auth()->user()->wishlistGames()->with('developer')->latest('wishlists.created_at')->limit(3)->get();
                @endphp
                
                @if($recentWishlist->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentWishlist as $game)
                            <div class="flex items-center space-x-3 p-3 bg-gray-700 rounded-lg">
                                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ substr($game->title, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-white font-medium">{{ $game->title }}</p>
                                    <p class="text-gray-400 text-sm">{{ $game->developer->name ?? 'Unknown' }}</p>
                                </div>
                                <span class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">
                                    ⭐ {{ number_format((float)$game->rating, 1) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('wishlist.index') }}" class="block mt-4 text-indigo-400 hover:text-indigo-300 text-sm">
                        View all wishlist items →
                    </a>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-400 mb-3">Your wishlist is empty</p>
                        <a href="{{ route('games.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Browse Games
                        </a>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <h2 class="text-xl font-semibold text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('games.index') }}" class="flex items-center space-x-3 p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">Browse Games</p>
                            <p class="text-gray-400 text-sm">Explore our game database</p>
                        </div>
                    </a>

                    <a href="{{ route('genres.index') }}" class="flex items-center space-x-3 p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">Browse by Genre</p>
                            <p class="text-gray-400 text-sm">Find games by category</p>
                        </div>
                    </a>

                    <a href="{{ route('wishlist.index') }}" class="flex items-center space-x-3 p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">My Wishlist</p>
                            <p class="text-gray-400 text-sm">View saved games</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
