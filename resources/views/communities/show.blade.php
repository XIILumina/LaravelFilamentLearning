<x-layouts.app :title="$community->name">
    <div class="min-h-screen bg-zinc-950">
        <!-- Community Header -->
        <div class="relative">
            <!-- Banner -->
            @if($community->banner_url)
                <div class="h-28 sm:h-36 md:h-44 overflow-hidden">
                    <img src="{{ $community->banner_url }}" 
                         alt="{{ $community->name }} banner" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-transparent to-transparent"></div>
                </div>
            @else
                <div class="h-28 sm:h-36 md:h-44 bg-gradient-to-br from-orange-600/30 to-zinc-900"></div>
            @endif

            <!-- Back Button -->
            <a href="{{ route('communities.index') }}" 
               class="absolute top-4 left-4 bg-zinc-900/80 backdrop-blur-sm text-white p-2 rounded-full hover:bg-zinc-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <!-- Community Info Overlay -->
            <div class="relative -mt-12 px-4 sm:px-6">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-end gap-4">
                        <!-- Community Icon -->
                        @if($community->icon_url)
                            <img src="{{ $community->icon_url }}" 
                                 alt="{{ $community->name }}" 
                                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border-4 border-zinc-950 object-cover shadow-xl">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-zinc-800 rounded-2xl border-4 border-zinc-950 flex items-center justify-center shadow-xl">
                                <span class="text-3xl sm:text-4xl">🎮</span>
                            </div>
                        @endif

                        <!-- Community Details -->
                        <div class="flex-1 min-w-0 pb-1">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white truncate">{{ $community->name }}</h1>
                            <p class="text-sm text-zinc-400 font-medium">{{ $community->hashtag }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats & Actions Bar -->
        <div class="px-4 sm:px-6 py-4 border-b border-zinc-800">
            <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 text-sm text-zinc-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="font-medium text-white">{{ number_format($community->subscriber_count) }}</span> members
                    </span>
                    <span class="hidden sm:flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium text-white">{{ number_format($community->post_count) }}</span> posts
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        @if($isSubscribed)
                            <form method="POST" action="{{ route('communities.unsubscribe', $community) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Joined
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('communities.subscribe', $community) }}">
                                @csrf
                                <button type="submit" 
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                                    Join
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('blog.create', ['community' => $community->id]) }}" 
                           class="bg-zinc-800 hover:bg-zinc-700 text-white p-2 rounded-xl transition" title="Create Post">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                            Login to Join
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-6">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Posts Feed -->
                    <div class="lg:col-span-2 space-y-4">
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                                <article class="bg-zinc-900 border border-zinc-800 rounded-2xl hover:border-zinc-700 transition overflow-hidden">
                                    <div class="flex gap-3 p-4">
                                        <!-- Vote Column -->
                                        <div class="flex flex-col items-center gap-1 shrink-0">
                                            <button class="text-zinc-500 hover:text-orange-500 transition p-1">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 5.414 3.707 11.707a1 1 0 01-1.414-1.414l7-7A1 1 0 0110 3z"/>
                                                </svg>
                                            </button>
                                            <span class="text-sm font-bold text-zinc-400">{{ $post->likes_count ?? 0 }}</span>
                                            <button class="text-zinc-500 hover:text-blue-500 transition p-1">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 17a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 14.586l6.293-6.293a1 1 0 011.414 1.414l-7 7A1 1 0 0110 17z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Post Content -->
                                        <div class="flex-1 min-w-0">
                                            <!-- Meta -->
                                            <div class="flex items-center gap-2 text-xs text-zinc-500 mb-2">
                                                <span class="font-medium text-zinc-400 hover:text-white cursor-pointer">u/{{ $post->user->name }}</span>
                                                <span>•</span>
                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            <!-- Title -->
                                            <h3 class="text-base sm:text-lg font-semibold text-white mb-2 hover:text-orange-500 transition">
                                                <a href="{{ route('communities.post', [$community, $post]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            
                                            <!-- Image -->
                                            @if($post->photo)
                                                <div class="mb-3 -mx-4 sm:mx-0">
                                                    <img src="{{ asset('storage/' . $post->photo) }}" 
                                                         alt="Post image" 
                                                         class="sm:rounded-xl max-h-80 w-full object-cover">
                                                </div>
                                            @endif
                                            
                                            <!-- Excerpt -->
                                            <p class="text-sm text-zinc-400 line-clamp-2 mb-3">
                                                {{ Str::limit(strip_tags($post->content), 150) }}
                                            </p>
                                            
                                            <!-- Actions -->
                                            <div class="flex items-center gap-4 text-xs text-zinc-500">
                                                <a href="{{ route('communities.post', [$community, $post]) }}" 
                                                   class="flex items-center gap-1.5 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $post->comments_count }} comments
                                                </a>
                                                <button class="flex items-center gap-1.5 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                    </svg>
                                                    Share
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                            <!-- Pagination -->
                            <div class="pt-4">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 sm:p-12 text-center">
                                <div class="w-16 h-16 bg-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white mb-2">No Posts Yet</h3>
                                <p class="text-zinc-500 text-sm mb-6">Be the first to start a discussion!</p>
                                @auth
                                    <a href="{{ route('blog.create', ['community' => $community->id]) }}" 
                                       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-medium transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create First Post
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-medium transition">
                                        Login to Post
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="space-y-4 lg:block hidden">
                        <!-- About Community -->
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4">
                            <h3 class="font-semibold text-white mb-3">About Community</h3>
                            @if($community->description)
                                <p class="text-sm text-zinc-400 mb-4 leading-relaxed">{{ $community->description }}</p>
                            @endif
                            
                            <div class="space-y-3 text-sm border-t border-zinc-800 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-zinc-500">Members</span>
                                    <span class="text-white font-medium">{{ number_format($community->subscriber_count) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-zinc-500">Posts</span>
                                    <span class="text-white font-medium">{{ number_format($community->post_count) }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-zinc-500">Created</span>
                                    <span class="text-white font-medium">{{ $community->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            @if($community->game)
                                <div class="border-t border-zinc-800 pt-4 mt-4">
                                    <p class="text-xs text-zinc-500 mb-2">Related Game</p>
                                    <a href="{{ route('games.show', $community->game) }}" 
                                       class="flex items-center gap-2 text-sm text-orange-500 hover:text-orange-400 font-medium group">
                                        {{ $community->game->title }}
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        @if($community->rules && count($community->rules) > 0)
                            <!-- Community Rules -->
                            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4">
                                <h3 class="font-semibold text-white mb-3">Community Rules</h3>
                                <ol class="space-y-2">
                                    @foreach($community->rules as $index => $ruleData)
                                        <li class="flex gap-2 text-sm">
                                            <span class="text-orange-500 font-medium">{{ $index + 1 }}.</span>
                                            <span class="text-zinc-400">{{ $ruleData['rule'] ?? $ruleData }}</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-zinc-900/95 backdrop-blur-lg border-t border-zinc-800 sm:hidden z-50">
            <div class="flex items-center justify-around py-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="{{ route('games.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                    </svg>
                    <span class="text-xs mt-1">Games</span>
                </a>
                <a href="{{ route('communities.index') }}" class="flex flex-col items-center p-2 text-orange-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Communities</span>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="text-xs mt-1">Profile</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center p-2 text-zinc-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-xs mt-1">Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app>
