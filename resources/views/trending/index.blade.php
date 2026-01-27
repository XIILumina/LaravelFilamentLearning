<x-layouts.app title="Trending">
    <div class="min-h-screen bg-zinc-950 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                    Trending Communities & Topics
                </h1>
                <p class="text-zinc-400 mt-2">Discover the most popular communities and posts right now</p>
            </div>

            <!-- Trending Communities Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6">🔥 Trending Communities</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($trendingCommunities as $community)
                        <a href="{{ route('communities.show', $community) }}" 
                           class="bg-zinc-900 rounded-lg p-6 hover:bg-zinc-800 transition-all hover:scale-105 border border-zinc-800 hover:border-orange-500/50">
                            <div class="flex items-start gap-4">
                                @if($community->icon_url)
                                    <img src="{{ $community->icon_url }}" 
                                         alt="{{ $community->name }}" 
                                         class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 bg-zinc-800 rounded-lg flex items-center justify-center text-2xl">
                                        🎮
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-white truncate">{{ $community->name }}</h3>
                                    <p class="text-sm text-zinc-400">{{ $community->hashtag }}</p>
                                    
                                    <div class="flex items-center gap-4 mt-3 text-sm text-zinc-500">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            {{ number_format($community->subscriber_count) }} subscribers
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            {{ number_format($community->post_count) }} posts
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($community->description)
                                <p class="text-sm text-zinc-400 mt-4 line-clamp-2">{{ $community->description }}</p>
                            @endif
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-zinc-500">No trending communities yet. Be the first to start one!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Trending Posts Section -->
            <div>
                <h2 class="text-2xl font-bold text-white mb-6">📈 Hot Posts This Week</h2>
                <div class="space-y-4">
                    @forelse($trendingPosts as $post)
                        <a href="{{ route('communities.post', [$post->community, $post]) }}" 
                           class="block bg-zinc-900 rounded-lg p-6 hover:bg-zinc-800 transition-all border border-zinc-800 hover:border-orange-500/50">
                            <div class="flex items-start gap-4">
                                <div class="flex-1">
                                    <!-- Community Badge -->
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($post->community->icon_url)
                                            <img src="{{ $post->community->icon_url }}" 
                                                 alt="{{ $post->community->name }}" 
                                                 class="w-6 h-6 rounded object-cover">
                                        @endif
                                        <span class="text-sm text-orange-500 font-medium">{{ $post->community->hashtag }}</span>
                                        <span class="text-zinc-600">•</span>
                                        <span class="text-sm text-zinc-500">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Post Title -->
                                    <h3 class="text-xl font-semibold text-white mb-2">{{ $post->title }}</h3>

                                    <!-- Post Preview -->
                                    @if($post->content)
                                        <p class="text-zinc-400 line-clamp-2 mb-4">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                    @endif

                                    <!-- Post Meta -->
                                    <div class="flex items-center gap-6 text-sm text-zinc-500">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $post->user->name }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                            {{ $post->likes_count }} likes
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            {{ $post->comments_count }} comments
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12 bg-zinc-900 rounded-lg">
                            <p class="text-zinc-500">No trending posts this week. Start posting to get featured!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 bg-gradient-to-r from-orange-600/20 to-red-600/20 rounded-lg p-8 border border-orange-500/30">
                <h3 class="text-2xl font-bold text-white mb-2">Join the Conversation</h3>
                <p class="text-zinc-300 mb-4">Subscribe to communities to get notifications about new posts and announcements!</p>
                <a href="{{ route('communities.index') }}" 
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Browse All Communities
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
