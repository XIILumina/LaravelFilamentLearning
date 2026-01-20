<x-layouts.app :title="__('Dashboard')">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800/50">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1">
                    Hey, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-zinc-400 text-sm sm:text-base">
                    @if(auth()->user()->isAdmin())
                        Admin Dashboard
                    @else
                        Your personalized feed
                    @endif
                </p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            @if(auth()->user()->isAdmin())
                <!-- ADMIN DASHBOARD -->
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                    <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                        <p class="text-xs text-zinc-500 mb-1">Users</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                        <p class="text-xs text-zinc-500 mb-1">Posts</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Post::count() }}</p>
                    </div>
                    <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                        <p class="text-xs text-zinc-500 mb-1">Games</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Game::count() }}</p>
                    </div>
                    <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                        <p class="text-xs text-zinc-500 mb-1">Communities</p>
                        <p class="text-2xl font-bold text-white">{{ \App\Models\Community::count() }}</p>
                    </div>
                </div>

                <!-- Admin Panel Link -->
                <a href="{{ url('/admin') }}" 
                   class="block p-6 bg-gradient-to-r from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-2xl hover:border-orange-500/40 transition-all group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-white group-hover:text-orange-400 transition-colors mb-1">
                                Open Admin Panel
                            </h3>
                            <p class="text-sm text-zinc-400">Manage games, users, attributes, and more</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>

            @else
                <!-- USER DASHBOARD -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Main Feed -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="font-semibold text-white">Your Feed</h2>
                        </div>

                        @php
                            $subscribedCommunityIds = auth()->user()->subscribedCommunities()->pluck('communities.id');
                            $feedPosts = \App\Models\Post::with(['user', 'game', 'community'])
                                ->whereHas('community')
                                ->when($subscribedCommunityIds->isNotEmpty(), function($query) use ($subscribedCommunityIds) {
                                    $query->whereIn('community_id', $subscribedCommunityIds);
                                })
                                ->orderByDesc('created_at')
                                ->limit(10)
                                ->get();
                        @endphp

                        @forelse($feedPosts as $post)
                            <a href="{{ route('communities.post', [$post->community, $post]) }}" 
                               class="block p-4 bg-zinc-800/30 border border-zinc-700/30 rounded-2xl hover:border-zinc-600/50 transition-all group">
                                <div class="flex items-start gap-3">
                                    <!-- Vote count (mobile-friendly) -->
                                    <div class="hidden sm:flex flex-col items-center justify-center bg-zinc-800/50 rounded-xl px-2 py-2 min-w-[50px]">
                                        <span class="font-semibold text-white text-sm">{{ $post->likes_count ?? 0 }}</span>
                                        <span class="text-[10px] text-zinc-500">votes</span>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-zinc-500 mb-1">
                                            @if($post->community)
                                                <span class="text-orange-400 font-medium">{{ $post->community->hashtag }}</span>
                                                <span class="hidden sm:inline">•</span>
                                            @endif
                                            <span class="hidden sm:inline">{{ $post->user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <h3 class="font-medium text-white group-hover:text-orange-400 transition-colors line-clamp-2 mb-1">
                                            {{ $post->title }}
                                        </h3>
                                        
                                        <p class="text-sm text-zinc-400 line-clamp-2 hidden sm:block">
                                            {{ Str::limit(strip_tags($post->content), 120) }}
                                        </p>
                                        
                                        <div class="flex items-center gap-3 mt-2 text-xs text-zinc-500">
                                            <span class="sm:hidden font-medium text-white">{{ $post->likes_count ?? 0 }} votes</span>
                                            <span>{{ $post->comments_count ?? 0 }} comments</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12 bg-zinc-800/20 border border-zinc-700/30 rounded-2xl">
                                <div class="w-12 h-12 rounded-xl bg-zinc-800 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                                <h3 class="font-medium text-white mb-1">No posts yet</h3>
                                <p class="text-sm text-zinc-500 mb-4">Join communities to see posts</p>
                                <a href="{{ route('communities.index') }}" class="inline-block px-4 py-2 bg-orange-500 hover:bg-orange-600 rounded-xl text-white text-sm font-medium transition-colors">
                                    Explore Communities
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-4">
                        <!-- Quick Stats -->
                        <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                            <h3 class="font-semibold text-white mb-3 text-sm">Your Stats</h3>
                            <div class="grid grid-cols-3 gap-3 text-center">
                                <div>
                                    <p class="text-lg font-bold text-white">{{ auth()->user()->wishlistGames()->count() }}</p>
                                    <p class="text-[10px] text-zinc-500">Wishlist</p>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-white">{{ auth()->user()->posts()->count() }}</p>
                                    <p class="text-[10px] text-zinc-500">Posts</p>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-white">{{ auth()->user()->subscribedCommunities()->count() }}</p>
                                    <p class="text-[10px] text-zinc-500">Communities</p>
                                </div>
                            </div>
                            <a href="{{ route('blog.create') }}" class="block mt-4 text-center bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-xl text-sm font-medium transition-colors">
                                Create Post
                            </a>
                        </div>

                        <!-- My Communities -->
                        <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                            <h3 class="font-semibold text-white mb-3 text-sm">My Communities</h3>
                            @php
                                $myCommunities = auth()->user()->subscribedCommunities()->limit(5)->get();
                            @endphp
                            
                            @if($myCommunities->count() > 0)
                                <div class="space-y-2">
                                    @foreach($myCommunities as $community)
                                        <a href="{{ route('communities.show', $community) }}" class="flex items-center gap-2 p-2 -mx-2 rounded-xl hover:bg-zinc-800/50 transition-colors group">
                                            <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center text-xs">🎮</div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-white group-hover:text-orange-400 truncate">{{ $community->name }}</p>
                                                <p class="text-[10px] text-zinc-500">{{ number_format($community->subscriber_count) }} members</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <a href="{{ route('communities.index') }}" class="block mt-3 pt-3 border-t border-zinc-700/50 text-xs text-orange-400 hover:text-orange-300">
                                    View All →
                                </a>
                            @else
                                <p class="text-sm text-zinc-500 mb-3">No communities joined yet</p>
                                <a href="{{ route('communities.index') }}" class="block text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-xl text-sm transition-colors">
                                    Browse
                                </a>
                            @endif
                        </div>

                        <!-- Recent Wishlist -->
                        <div class="bg-zinc-800/30 border border-zinc-700/30 rounded-2xl p-4">
                            <h3 class="font-semibold text-white mb-3 text-sm">Wishlist</h3>
                            @php
                                $recentWishlist = auth()->user()->wishlistGames()->with('developer')->latest('wishlists.created_at')->limit(3)->get();
                            @endphp
                            
                            @if($recentWishlist->count() > 0)
                                <div class="space-y-2">
                                    @foreach($recentWishlist as $game)
                                        <a href="{{ route('games.show', $game) }}" class="flex items-center gap-2 p-2 -mx-2 rounded-xl hover:bg-zinc-800/50 transition-colors group">
                                            <div class="w-8 h-8 bg-zinc-700 rounded-lg flex items-center justify-center text-xs">🎮</div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-white group-hover:text-orange-400 truncate">{{ $game->title }}</p>
                                                <p class="text-[10px] text-zinc-500">★ {{ number_format((float)($game->rating ?? 0), 1) }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <a href="{{ route('wishlist.index') }}" class="block mt-3 pt-3 border-t border-zinc-700/50 text-xs text-orange-400 hover:text-orange-300">
                                    View All →
                                </a>
                            @else
                                <p class="text-sm text-zinc-500 mb-3">Wishlist empty</p>
                                <a href="{{ route('games.index') }}" class="block text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-xl text-sm transition-colors">
                                    Browse Games
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
