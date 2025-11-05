<x-layouts.app :title="$post->title">
    <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('blog.index') }}" 
               class="text-zinc-400 hover:text-indigo-400 transition-colors">
                ← Back to Blog
            </a>
        </div>

        <!-- Main Post -->
        <article class="bg-zinc-800 rounded-xl overflow-hidden mb-8">
            <div class="p-8">
                <!-- Post Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ $post->user->initials() }}
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="text-zinc-300 font-medium text-lg">{{ $post->user->name }}</span>
                                @if($post->is_pinned)
                                    <span class="bg-green-600 text-xs px-2 py-1 rounded">📌 Pinned</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-zinc-400">
                                <span>{{ $post->created_at->format('M d, Y \a\t g:i A') }}</span>
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
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Delete this post?')"
                                            class="text-zinc-400 hover:text-red-400 transition-colors">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Post Title -->
                <h1 class="text-3xl font-bold text-white mb-6">{{ $post->title }}</h1>

                <!-- Post Photo -->
                @if($post->photo)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $post->photo) }}" 
                             alt="Post image" 
                             class="rounded-lg max-w-full h-auto">
                    </div>
                @endif

                <!-- Post Content -->
                <div class="text-zinc-300 text-lg leading-relaxed mb-6">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Post Actions -->
                <div class="flex items-center space-x-6 pt-6 border-t border-zinc-700">
                    @auth
                        <div class="flex items-center space-x-2">
                            <button onclick="togglePostLike({{ $post->id }}, true)" 
                                    class="flex items-center space-x-1 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'text-green-400' : 'text-zinc-400 hover:text-green-400' }}">
                                <span>👍</span>
                                <span id="post-likes-{{ $post->id }}">{{ $post->likes_count }}</span>
                            </button>
                            <button onclick="togglePostLike({{ $post->id }}, false)" 
                                    class="flex items-center space-x-1 transition-colors {{ $post->isDislikedBy(auth()->user()) ? 'text-red-400' : 'text-zinc-400 hover:text-red-400' }}">
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

                    <span class="flex items-center space-x-1 text-zinc-400">
                        <span>💬</span>
                        <span>{{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}</span>
                    </span>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-zinc-800 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Comments</h2>

            <!-- Add Comment Form -->
            @auth
                <div class="mb-8">
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-4">
                        @csrf
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ auth()->user()->initials() }}
                            </div>
                            <div class="flex-1">
                                <textarea name="content" 
                                          rows="3" 
                                          placeholder="Write a comment..." 
                                          class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-3 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 resize-none"
                                          required></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg text-white font-medium transition-colors">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-8 text-center py-6 bg-zinc-700 rounded-lg">
                    <p class="text-zinc-400 mb-4">You need to be logged in to comment</p>
                    <a href="{{ route('login') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg text-white font-medium transition-colors">
                        Login
                    </a>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6" id="comments-container">
                @include('blog.partials.comments', ['comments' => $post->comments->whereNull('parent_id')])
            </div>

            @if($post->comments->where('parent_id', null)->isEmpty())
                <div class="text-center py-8">
                    <div class="text-zinc-400 text-4xl mb-4">💬</div>
                    <p class="text-zinc-400">No comments yet. Be the first to comment!</p>
                </div>
            @endif
        </div>
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

            function toggleCommentLike(commentId, isLike) {
                fetch(`/blog/comments/${commentId}/like`, {
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
                        document.getElementById(`comment-likes-${commentId}`).textContent = data.likes_count;
                        document.getElementById(`comment-dislikes-${commentId}`).textContent = data.dislikes_count;
                        
                        // Update button styles
                        const likeBtn = document.querySelector(`button[onclick="toggleCommentLike(${commentId}, true)"]`);
                        const dislikeBtn = document.querySelector(`button[onclick="toggleCommentLike(${commentId}, false)"]`);
                        
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

            function toggleReplyForm(commentId) {
                const form = document.getElementById(`reply-form-${commentId}`);
                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            }
        </script>
    @endauth
</x-layouts.app>