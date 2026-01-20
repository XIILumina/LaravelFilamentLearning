<x-layouts.app title="Blog">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">Discussions</h1>
                        <p class="text-zinc-500 text-sm mt-1">Share your gaming experiences</p>
                    </div>
                    @auth
                        <a href="{{ route('blog.create') }}" 
                           class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-xl font-medium text-white text-sm transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="hidden sm:inline">Create Post</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="px-4 sm:px-6 py-4 border-b border-zinc-800 bg-zinc-900/50">
            <div class="max-w-4xl mx-auto">
                <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search posts..." 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                    </div>
                    <div class="flex gap-2">
                        <select name="game" 
                                class="flex-1 sm:w-36 bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2.5 text-white text-sm focus:ring-2 focus:ring-orange-500">
                            <option value="">All Games</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }}
                                </option>
                            @endforeach
                        </select>
                        <select name="community" 
                                class="flex-1 sm:w-40 bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2.5 text-white text-sm focus:ring-2 focus:ring-orange-500">
                            <option value="">All Communities</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->id }}" {{ request('community') == $community->id ? 'selected' : '' }}>
                                    {{ $community->hashtag }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" 
                                class="bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 px-4 py-2.5 rounded-xl text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
                @if(request('search') || request('game') || request('community'))
                    <div class="mt-3">
                        <a href="{{ route('blog.index') }}" 
                           class="text-sm text-orange-500 hover:text-orange-400">
                            Clear filters ×
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Posts -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-12">
            <div class="max-w-4xl mx-auto space-y-4">
                @forelse($posts as $post)
                    <article class="bg-zinc-900 border border-zinc-800 rounded-2xl hover:border-zinc-700 transition overflow-hidden">
                        <div class="flex gap-3 p-4">
                            <!-- Vote Column -->
                            <div class="flex flex-col items-center gap-1 shrink-0">
                                @auth
                                    <button onclick="togglePostLike({{ $post->id }}, true)" 
                                            class="p-1 transition {{ $post->isLikedBy(auth()->user()) ? 'text-orange-500' : 'text-zinc-500 hover:text-orange-500' }}"
                                            data-post-id="{{ $post->id }}"
                                            data-action="like">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 5.414 3.707 11.707a1 1 0 01-1.414-1.414l7-7A1 1 0 0110 3z"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="p-1 text-zinc-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 5.414 3.707 11.707a1 1 0 01-1.414-1.414l7-7A1 1 0 0110 3z"/>
                                        </svg>
                                    </span>
                                @endauth
                                <span class="text-sm font-bold text-zinc-400 like-count" data-post-id="{{ $post->id }}">{{ $post->likes_count - $post->dislikes_count }}</span>
                                @auth
                                    <button onclick="togglePostLike({{ $post->id }}, false)" 
                                            class="p-1 transition {{ $post->isDislikedBy(auth()->user()) ? 'text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}"
                                            data-post-id="{{ $post->id }}"
                                            data-action="dislike">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 17a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 14.586l6.293-6.293a1 1 0 011.414 1.414l-7 7A1 1 0 0110 17z"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="p-1 text-zinc-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 17a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 14.586l6.293-6.293a1 1 0 011.414 1.414l-7 7A1 1 0 0110 17z"/>
                                        </svg>
                                    </span>
                                @endauth
                            </div>
                            
                            <!-- Post Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Meta -->
                                <div class="flex flex-wrap items-center gap-2 text-xs text-zinc-500 mb-2">
                                    <span class="font-medium text-zinc-400">u/{{ $post->user->name }}</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                    @if($post->community)
                                        <a href="{{ route('communities.show', $post->community) }}" 
                                           class="bg-orange-500/10 text-orange-500 px-2 py-0.5 rounded-lg hover:bg-orange-500/20 transition">
                                            {{ $post->community->hashtag }}
                                        </a>
                                    @endif
                                    @if($post->game)
                                        <a href="{{ route('games.show', $post->game) }}" 
                                           class="bg-zinc-800 text-zinc-400 px-2 py-0.5 rounded-lg hover:text-white transition">
                                            🎮 {{ $post->game->title }}
                                        </a>
                                    @endif
                                    @if($post->is_pinned)
                                        <span class="bg-green-500/10 text-green-500 px-2 py-0.5 rounded-lg">📌 Pinned</span>
                                    @endif
                                </div>
                                
                                <!-- Title -->
                                <h2 class="text-base sm:text-lg font-semibold text-white mb-2 hover:text-orange-500 transition">
                                    <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                                </h2>

                                <!-- Content Preview -->
                                <p class="text-sm text-zinc-400 line-clamp-2 mb-3">
                                    {{ Str::limit(strip_tags($post->content), 150) }}
                                </p>

                                <!-- Photo Preview -->
                                @if($post->photo)
                                    <div class="mb-3 -mx-4 sm:mx-0">
                                        <img src="{{ asset('storage/' . $post->photo) }}" 
                                             alt="Post image" 
                                             class="sm:rounded-xl max-h-64 w-full object-cover">
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="flex items-center gap-4 text-xs text-zinc-500">
                                    <a href="{{ route('blog.show', $post) }}" 
                                       class="flex items-center gap-1.5 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
                                    </a>
                                    <button class="flex items-center gap-1.5 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                        Share
                                    </button>
                                    @auth
                                        @if($post->user_id === auth()->id())
                                            <a href="{{ route('blog.edit', $post) }}" 
                                               class="flex items-center gap-1.5 hover:text-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Delete this post?')"
                                                        class="flex items-center gap-1.5 hover:text-red-400 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">No posts yet</h3>
                        <p class="text-zinc-500 text-sm mb-6">Be the first to start a discussion!</p>
                        @auth
                            <a href="{{ route('blog.create') }}" 
                               class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Post
                            </a>
                        @endauth
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="pt-4">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                @endif
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
                <a href="{{ route('communities.index') }}" class="flex flex-col items-center p-2 text-zinc-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
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

    @auth
        <script>
            const activeRequests = new Set();

            function togglePostLike(postId, isLike) {
                const requestKey = `post-${postId}`;
                if (activeRequests.has(requestKey)) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) return;

                const likeBtn = document.querySelector(`[data-post-id="${postId}"][data-action="like"]`);
                const dislikeBtn = document.querySelector(`[data-post-id="${postId}"][data-action="dislike"]`);
                const countEl = document.querySelector(`.like-count[data-post-id="${postId}"]`);

                if (!likeBtn || !dislikeBtn || !countEl) return;

                likeBtn.style.opacity = '0.5';
                dislikeBtn.style.opacity = '0.5';
                activeRequests.add(requestKey);

                fetch(`/blog/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ is_like: isLike })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        countEl.textContent = data.likes_count - data.dislikes_count;
                        
                        likeBtn.classList.remove('text-orange-500', 'text-zinc-500');
                        dislikeBtn.classList.remove('text-blue-500', 'text-zinc-500');
                        
                        likeBtn.classList.add(data.user_liked ? 'text-orange-500' : 'text-zinc-500');
                        dislikeBtn.classList.add(data.user_disliked ? 'text-blue-500' : 'text-zinc-500');
                    }
                })
                .catch(console.error)
                .finally(() => {
                    likeBtn.style.opacity = '1';
                    dislikeBtn.style.opacity = '1';
                    activeRequests.delete(requestKey);
                });
            }
        </script>
    @endauth
</x-layouts.app>
