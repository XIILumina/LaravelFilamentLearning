<x-layouts.app :title="$post->title">
    <div class="container mx-auto px-4 py-8 pb-96">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-zinc-400">
                <li><a href="{{ route('communities.index') }}" class="hover:text-indigo-400">Communities</a></li>
                <li><span class="text-zinc-600">/</span></li>
                <li><a href="{{ route('communities.show', $community) }}" class="hover:text-indigo-400">{{ $community->name }}</a></li>
                <li><span class="text-zinc-600">/</span></li>
                <li class="text-zinc-300">{{ Str::limit($post->title, 30) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Post Content -->
                <article class="bg-zinc-800 rounded-xl p-6 mb-6">
                    <!-- Post Header -->
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-zinc-700">
                        <!-- Author Avatar -->
                        <div class="w-12 h-12 bg-zinc-700 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-zinc-300">
                                {{ substr($post->user->name, 0, 1) }}
                            </span>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-white">{{ $post->user->name }}</span>
                                <span class="bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $community->hashtag }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-zinc-400">
                                <time>{{ $post->created_at->format('M j, Y \a\t g:i A') }}</time>
                                @if($post->game)
                                    <span>•</span>
                                    <span>{{ $post->game->title }}</span>
                                @endif
                                @if($post->created_at != $post->updated_at)
                                    <span>•</span>
                                    <span>edited {{ $post->updated_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Post Actions -->
                        @auth
                            @if($post->user_id === Auth::id())
                                <div class="flex gap-2">
                                    <a href="{{ route('blog.edit', $post) }}" 
                                       class="text-zinc-400 hover:text-indigo-400 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('blog.destroy', $post) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this post?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-400 hover:text-red-400 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Post Title -->
                    <h1 class="text-3xl font-bold text-white mb-6">{{ $post->title }}</h1>

                    <!-- Post Image -->
                    @if($post->photo)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $post->photo) }}" 
                                 alt="Post image" 
                                 class="rounded-lg max-w-full h-auto">
                        </div>
                    @endif

                    <!-- Post Content -->
                    <div class="prose prose-invert max-w-none mb-6">
                        <div class="text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</div>
                    </div>

                    <!-- Post Reactions -->
                    @auth
                        <div class="flex items-center gap-4 pt-4 border-t border-zinc-700">
                            <button onclick="toggleLike({{ $post->id }}, 'like')" 
                                    class="like-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors {{ $post->isLikedBy(Auth::user()) ? 'bg-green-600 text-white' : 'bg-zinc-700 text-zinc-300 hover:bg-zinc-600' }}"
                                    data-post-id="{{ $post->id }}"
                                    data-type="like">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                </svg>
                                <span class="like-count">{{ $post->likes_count ?? 0 }}</span>
                            </button>

                            <button onclick="toggleLike({{ $post->id }}, 'dislike')" 
                                    class="dislike-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors {{ $post->isDislikedBy(Auth::user()) ? 'bg-red-600 text-white' : 'bg-zinc-700 text-zinc-300 hover:bg-zinc-600' }}"
                                    data-post-id="{{ $post->id }}"
                                    data-type="dislike">
                                <svg class="w-5 h-5 transform rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                </svg>
                                <span class="dislike-count">{{ $post->dislikes_count ?? 0 }}</span>
                            </button>
                        </div>
                    @endauth
                </article>

                <!-- Comments Section -->
                @include('blog.partials.comments', ['post' => $post])
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Community Info -->
                <div class="bg-zinc-800 rounded-xl p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        @if($community->icon_url)
                            <img src="{{ $community->icon_url }}" 
                                 alt="{{ $community->name }}" 
                                 class="w-12 h-12 rounded-lg object-cover">
                        @else
                            <div class="w-12 h-12 bg-zinc-700 rounded-lg flex items-center justify-center">
                                <span class="text-xl">🎮</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-white">{{ $community->name }}</h3>
                            <span class="text-indigo-400 text-sm">{{ $community->hashtag }}</span>
                        </div>
                    </div>

                    @if($community->description)
                        <p class="text-zinc-400 text-sm mb-4">{{ Str::limit($community->description, 100) }}</p>
                    @endif

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Members</span>
                            <span class="text-white">{{ number_format($community->subscriber_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Posts</span>
                            <span class="text-white">{{ number_format($community->post_count) }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-700">
                        <a href="{{ route('communities.show', $community) }}" 
                           class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            View Community
                        </a>
                    </div>
                </div>

                <!-- Related Posts -->
                @php
                    $relatedPosts = $community->posts()
                        ->where('id', '!=', $post->id)
                        ->latest()
                        ->take(3)
                        ->get();
                @endphp

                @if($relatedPosts->count() > 0)
                    <div class="bg-zinc-800 rounded-xl p-6">
                        <h3 class="font-bold text-white mb-4">More from {{ $community->hashtag }}</h3>
                        <div class="space-y-3">
                            @foreach($relatedPosts as $relatedPost)
                                <a href="{{ route('communities.post', [$community, $relatedPost]) }}" 
                                   class="block p-3 bg-zinc-700 rounded-lg hover:bg-zinc-600 transition-colors">
                                    <h4 class="font-medium text-white text-sm mb-1 line-clamp-2">{{ $relatedPost->title }}</h4>
                                    <p class="text-zinc-400 text-xs">{{ $relatedPost->created_at->diffForHumans() }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include the like/dislike JavaScript -->
    <script>
        async function toggleLike(postId, type) {
            try {
                const response = await fetch(`/blog/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type: type })
                });

                const data = await response.json();

                if (data.success) {
                    // Update like button
                    const likeBtn = document.querySelector('.like-btn[data-post-id="' + postId + '"]');
                    const dislikeBtn = document.querySelector('.dislike-btn[data-post-id="' + postId + '"]');
                    const likeCount = likeBtn.querySelector('.like-count');
                    const dislikeCount = dislikeBtn.querySelector('.dislike-count');

                    // Update counts
                    likeCount.textContent = data.likes_count;
                    dislikeCount.textContent = data.dislikes_count;

                    // Update button states
                    if (data.user_reaction === 'like') {
                        likeBtn.className = 'like-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-green-600 text-white';
                        dislikeBtn.className = 'dislike-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-zinc-700 text-zinc-300 hover:bg-zinc-600';
                    } else if (data.user_reaction === 'dislike') {
                        likeBtn.className = 'like-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-zinc-700 text-zinc-300 hover:bg-zinc-600';
                        dislikeBtn.className = 'dislike-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-red-600 text-white';
                    } else {
                        likeBtn.className = 'like-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-zinc-700 text-zinc-300 hover:bg-zinc-600';
                        dislikeBtn.className = 'dislike-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors bg-zinc-700 text-zinc-300 hover:bg-zinc-600';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function toggleCommentLike(commentId, isLike) {
            try {
                const response = await fetch(`/blog/comments/${commentId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ is_like: isLike })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.success) {
                    // Update the counts in the UI
                    const likeBtn = document.querySelector(`button[onclick="toggleCommentLike(${commentId}, true)"]`);
                    const dislikeBtn = document.querySelector(`button[onclick="toggleCommentLike(${commentId}, false)"]`);
                    
                    if (likeBtn && dislikeBtn) {
                        const likeCount = likeBtn.querySelector('.like-count');
                        const dislikeCount = dislikeBtn.querySelector('.dislike-count');
                        
                        if (likeCount) likeCount.textContent = data.likes_count || 0;
                        if (dislikeCount) dislikeCount.textContent = data.dislikes_count || 0;

                        // Update button states based on user's current reaction
                        if (data.user_reaction === 'like') {
                            likeBtn.classList.remove('text-zinc-400', 'hover:text-green-400');
                            likeBtn.classList.add('text-green-500');
                            dislikeBtn.classList.remove('text-red-500');
                            dislikeBtn.classList.add('text-zinc-400', 'hover:text-red-400');
                        } else if (data.user_reaction === 'dislike') {
                            dislikeBtn.classList.remove('text-zinc-400', 'hover:text-red-400');
                            dislikeBtn.classList.add('text-red-500');
                            likeBtn.classList.remove('text-green-500');
                            likeBtn.classList.add('text-zinc-400', 'hover:text-green-400');
                        } else {
                            // No reaction
                            likeBtn.classList.remove('text-green-500');
                            likeBtn.classList.add('text-zinc-400', 'hover:text-green-400');
                            dislikeBtn.classList.remove('text-red-500');
                            dislikeBtn.classList.add('text-zinc-400', 'hover:text-red-400');
                        }
                    }
                }
            } catch (error) {
                console.error('Error toggling comment like:', error);
            }
        }
    </script>
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app>