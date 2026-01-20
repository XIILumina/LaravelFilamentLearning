<x-layouts.app :title="$post->title">
    <div class="min-h-screen bg-zinc-950">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-4 border-b border-zinc-800 sticky top-0 bg-zinc-950/95 backdrop-blur-lg z-40">
            <div class="max-w-3xl mx-auto flex items-center gap-3">
                <a href="{{ route('blog.index') }}" 
                   class="text-zinc-400 hover:text-white p-2 -ml-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <span class="text-white font-medium truncate">{{ $post->title }}</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 sm:px-6 py-6 pb-24 sm:pb-12">
            <div class="max-w-3xl mx-auto">
                <!-- Post Card -->
                <article class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden mb-6">
                    <div class="p-5 sm:p-6">
                        <!-- Author & Meta -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ $post->user->initials() }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-white">{{ $post->user->name }}</span>
                                        @if($post->is_pinned)
                                            <span class="bg-green-500/10 text-green-500 text-xs px-2 py-0.5 rounded-lg">📌 Pinned</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 text-sm text-zinc-500">
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        @if($post->game)
                                            <a href="{{ route('games.show', $post->game) }}" 
                                               class="text-zinc-400 hover:text-white transition">
                                                🎮 {{ $post->game->title }}
                                            </a>
                                        @endif
                                        @if($post->community)
                                            <a href="{{ route('communities.show', $post->community) }}" 
                                               class="bg-orange-500/10 text-orange-500 px-2 py-0.5 rounded-lg hover:bg-orange-500/20 transition">
                                                {{ $post->community->hashtag }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @auth
                                @if($post->user_id === auth()->id())
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('blog.edit', $post) }}" 
                                           class="text-zinc-500 hover:text-white p-2 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this post?')"
                                                    class="text-zinc-500 hover:text-red-500 p-2 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Title -->
                        <h1 class="text-xl sm:text-2xl font-bold text-white mb-4">{{ $post->title }}</h1>

                        <!-- Photo -->
                        @if($post->photo)
                            <div class="mb-4 -mx-5 sm:-mx-6">
                                <img src="{{ asset('storage/' . $post->photo) }}" 
                                     alt="Post image" 
                                     class="w-full max-h-96 object-cover">
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="text-zinc-300 leading-relaxed whitespace-pre-line mb-6">{{ $post->content }}</div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-4 border-t border-zinc-800">
                            @auth
                                <div class="flex items-center gap-1">
                                    <button onclick="togglePostLike({{ $post->id }}, true)" 
                                            class="p-2 transition {{ $post->isLikedBy(auth()->user()) ? 'text-orange-500' : 'text-zinc-500 hover:text-orange-500' }}"
                                            data-post-id="{{ $post->id }}"
                                            data-action="like">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a1 1 0 01.707.293l7 7a1 1 0 01-1.414 1.414L10 5.414 3.707 11.707a1 1 0 01-1.414-1.414l7-7A1 1 0 0110 3z"/>
                                        </svg>
                                    </button>
                                    <span class="text-sm font-bold text-zinc-400 like-count">{{ $post->likes_count }}</span>
                                    <button onclick="togglePostLike({{ $post->id }}, false)" 
                                            class="p-2 transition {{ $post->isDislikedBy(auth()->user()) ? 'text-blue-500' : 'text-zinc-500 hover:text-blue-500' }}"
                                            data-post-id="{{ $post->id }}"
                                            data-action="dislike">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 17a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 14.586l6.293-6.293a1 1 0 011.414 1.414l-7 7A1 1 0 0110 17z"/>
                                        </svg>
                                    </button>
                                    <span class="text-sm font-bold text-zinc-400 dislike-count">{{ $post->dislikes_count }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-zinc-500 text-sm">
                                    <span>👍 {{ $post->likes_count }}</span>
                                    <span>👎 {{ $post->dislikes_count }}</span>
                                </div>
                            @endauth

                            <span class="flex items-center gap-1.5 text-zinc-500 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
                            </span>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
                    <div class="p-5 sm:p-6 border-b border-zinc-800">
                        <h2 class="text-lg font-semibold text-white">Comments</h2>
                    </div>

                    <!-- Add Comment -->
                    @auth
                        <div class="p-5 sm:p-6 border-b border-zinc-800">
                            <form method="POST" action="{{ route('comments.store', $post) }}" class="flex gap-3">
                                @csrf
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" 
                                              rows="2" 
                                              placeholder="Add a comment..." 
                                              class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none text-sm"
                                              required></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" 
                                                class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-xl text-white text-sm font-medium transition">
                                            Comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-5 sm:p-6 border-b border-zinc-800 text-center">
                            <p class="text-zinc-500 text-sm mb-3">Log in to comment</p>
                            <a href="{{ route('login') }}" 
                               class="inline-block bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-xl text-white text-sm font-medium transition">
                                Login
                            </a>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="divide-y divide-zinc-800" id="comments-container">
                        @include('blog.partials.comments', ['comments' => $post->comments->whereNull('parent_id')])
                    </div>

                    @if($post->comments->where('parent_id', null)->isEmpty())
                        <div class="p-8 text-center">
                            <div class="w-12 h-12 bg-zinc-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-zinc-500 text-sm">No comments yet. Be the first!</p>
                        </div>
                    @endif
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
                const likesCountEl = document.querySelector('.like-count');
                const dislikesCountEl = document.querySelector('.dislike-count');

                if (!likeBtn || !dislikeBtn) return;

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
                        if (likesCountEl) likesCountEl.textContent = data.likes_count;
                        if (dislikesCountEl) dislikesCountEl.textContent = data.dislikes_count;
                        
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

            function toggleCommentLike(commentId, isLike) {
                const requestKey = `comment-${commentId}`;
                if (activeRequests.has(requestKey)) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) return;

                const likeBtn = document.querySelector(`[data-comment-id="${commentId}"][data-action="like"]`);
                const dislikeBtn = document.querySelector(`[data-comment-id="${commentId}"][data-action="dislike"]`);

                if (!likeBtn || !dislikeBtn) return;

                likeBtn.style.opacity = '0.5';
                dislikeBtn.style.opacity = '0.5';
                activeRequests.add(requestKey);

                fetch(`/blog/comments/${commentId}/like`, {
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
                        const likesEl = likeBtn.querySelector('.like-count');
                        const dislikesEl = dislikeBtn.querySelector('.dislike-count');
                        if (likesEl) likesEl.textContent = data.likes_count;
                        if (dislikesEl) dislikesEl.textContent = data.dislikes_count;
                        
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

            function toggleReplyForm(commentId) {
                const form = document.getElementById(`reply-form-${commentId}`);
                if (form) {
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                }
            }
        </script>
    @endauth
</x-layouts.app>
