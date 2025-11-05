<x-layouts.app title="Blog">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">Game Discussion</h1>
                <p class="text-zinc-400">Share your thoughts, strategies, and experiences</p>
            </div>
            @auth
                <a href="{{ route('blog.create') }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg font-medium text-white transition-colors mt-4 md:mt-0">
                    Create Post
                </a>
            @endauth
        </div>

        <!-- Search and Filters -->
        <div class="bg-zinc-800 rounded-xl p-6 mb-8">
            <form method="GET" action="{{ route('blog.index') }}" class="space-y-4 md:space-y-0 md:flex md:gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts..." 
                           class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-2 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="md:w-48">
                    <select name="game" 
                            class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Games</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>
                                {{ $game->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg text-white transition-colors">
                    Search
                </button>
                @if(request('search') || request('game'))
                    <a href="{{ route('blog.index') }}" 
                       class="bg-zinc-600 hover:bg-zinc-700 px-6 py-2 rounded-lg text-white transition-colors">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Posts -->
        <div class="space-y-6">
            @forelse($posts as $post)
                <article class="bg-zinc-800 rounded-xl overflow-hidden hover:bg-zinc-750 transition-colors">
                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ $post->user->initials() }}
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-zinc-300 font-medium">{{ $post->user->name }}</span>
                                        @if($post->is_pinned)
                                            <span class="bg-green-600 text-xs px-2 py-1 rounded">📌 Pinned</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-zinc-400">
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        @if($post->game)
                                            <span>•</span>
                                            <a href="{{ route('games.show', $post->game) }}" 
                                               class="bg-zinc-700 hover:bg-zinc-600 px-2 py-1 rounded text-indigo-400 hover:text-indigo-300 transition-colors">
                                                🎮 {{ $post->game->title }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @auth
                                @if($post->user_id === auth()->id())
                                    <div class="flex space-x-2">
                                        <a href="{{ route('blog.edit', $post) }}" 
                                           class="text-zinc-400 hover:text-indigo-400 transition-colors">
                                            ✏️
                                        </a>
                                        <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Delete this post?')"
                                                    class="text-zinc-400 hover:text-red-400 transition-colors">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Post Title -->
                        <h2 class="text-xl font-bold text-white mb-3 hover:text-indigo-400 transition-colors">
                            <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                        </h2>

                        <!-- Post Content Preview -->
                        <div class="text-zinc-300 mb-4">
                            {{ Str::limit(strip_tags($post->content), 200) }}
                        </div>

                        <!-- Post Photo -->
                        @if($post->photo)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $post->photo) }}" 
                                     alt="Post image" 
                                     class="rounded-lg max-h-64 w-auto mx-auto">
                            </div>
                        @endif

                        <!-- Post Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-zinc-700">
                            <div class="flex items-center space-x-6">
                                <!-- Like/Dislike -->
                                @auth
                                    <div class="flex items-center space-x-2">
                                        <button onclick="togglePostLike({{ $post->id }}, true)" 
                                                class="flex items-center space-x-1 text-sm transition-colors {{ $post->isLikedBy(auth()->user()) ? 'text-green-400' : 'text-zinc-400 hover:text-green-400' }}">
                                            <span>👍</span>
                                            <span id="post-likes-{{ $post->id }}">{{ $post->likes_count }}</span>
                                        </button>
                                        <button onclick="togglePostLike({{ $post->id }}, false)" 
                                                class="flex items-center space-x-1 text-sm transition-colors {{ $post->isDislikedBy(auth()->user()) ? 'text-red-400' : 'text-zinc-400 hover:text-red-400' }}">
                                            <span>👎</span>
                                            <span id="post-dislikes-{{ $post->id }}">{{ $post->dislikes_count }}</span>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2 text-zinc-400">
                                        <span class="flex items-center space-x-1">
                                            <span>👍</span>
                                            <span>{{ $post->likes_count }}</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>👎</span>
                                            <span>{{ $post->dislikes_count }}</span>
                                        </span>
                                    </div>
                                @endauth

                                <!-- Comments -->
                                <a href="{{ route('blog.show', $post) }}" 
                                   class="flex items-center space-x-1 text-sm text-zinc-400 hover:text-indigo-400 transition-colors">
                                    <span>💬</span>
                                    <span>{{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}</span>
                                </a>
                            </div>

                            <a href="{{ route('blog.show', $post) }}" 
                               class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-12">
                    <div class="text-zinc-400 text-6xl mb-4">📝</div>
                    <h3 class="text-2xl font-semibold text-zinc-300 mb-2">No posts yet</h3>
                    <p class="text-zinc-400 mb-6">Be the first to start a discussion!</p>
                    @auth
                        <a href="{{ route('blog.create') }}" 
                           class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg font-medium text-white transition-colors">
                            Create Post
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @auth
        <script>
            function togglePostLike(postId, isLike) {
                fetch(`/blog/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        is_like: isLike
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`post-likes-${postId}`).textContent = data.likes_count;
                        document.getElementById(`post-dislikes-${postId}`).textContent = data.dislikes_count;
                        
                        // Update button styles
                        const likeBtn = document.querySelector(`button[onclick="togglePostLike(${postId}, true)"]`);
                        const dislikeBtn = document.querySelector(`button[onclick="togglePostLike(${postId}, false)"]`);
                        
                        // Reset styles
                        likeBtn.className = likeBtn.className.replace(/text-green-400/, 'text-zinc-400 hover:text-green-400');
                        dislikeBtn.className = dislikeBtn.className.replace(/text-red-400/, 'text-zinc-400 hover:text-red-400');
                        
                        // Apply active styles
                        if (data.user_liked) {
                            likeBtn.className = likeBtn.className.replace(/text-zinc-400 hover:text-green-400/, 'text-green-400');
                        }
                        if (data.user_disliked) {
                            dislikeBtn.className = dislikeBtn.className.replace(/text-zinc-400 hover:text-red-400/, 'text-red-400');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        </script>
    @endauth
</x-layouts.app>