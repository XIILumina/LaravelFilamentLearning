<x-layouts.app :title="$user->name . ' - Profile'">
    <div class="min-h-screen bg-zinc-950 py-8 pb-96">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-2xl border border-zinc-800 p-8 mb-6">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl flex items-center justify-center text-white text-4xl font-bold shadow-2xl ring-4 ring-orange-500/20">
                            {{ $user->initials() }}
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-4xl font-bold text-white">{{ $user->name }}</h1>
                            @if($user->role === 'admin')
                                <span class="bg-gradient-to-r from-red-600 to-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full">Admin</span>
                            @endif
                        </div>
                        @if($user->username)
                            <p class="text-xl text-zinc-400 mb-4">@{{ $user->username }}</p>
                        @endif
                        <p class="text-zinc-500 text-sm mb-6">🎮 Member since {{ $user->created_at->format('F Y') }}</p>

                        <!-- Stats -->
                        <div class="flex flex-wrap items-center gap-8">
                            <div>
                                <span class="text-3xl font-bold text-white">{{ $stats['posts'] }}</span>
                                <span class="text-zinc-400 text-sm ml-2">Posts</span>
                            </div>
                            <div>
                                <span class="text-3xl font-bold text-white">{{ $stats['comments'] }}</span>
                                <span class="text-zinc-400 text-sm ml-2">Comments</span>
                            </div>
                            <div>
                                <span class="text-3xl font-bold text-white">{{ $stats['communities'] }}</span>
                                <span class="text-zinc-400 text-sm ml-2">Communities</span>
                            </div>
                            <div>
                                <span class="text-3xl font-bold text-orange-500">{{ $stats['likes_received'] }}</span>
                                <span class="text-zinc-400 text-sm ml-2">Likes</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit') }}" 
                               class="bg-zinc-800 hover:bg-zinc-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Profile
                            </a>
                        @else
                            <a href="{{ route('messages.show', $user) }}" 
                               class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl text-sm font-medium transition flex items-center gap-2 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Message
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Subscribed Communities -->
                    @if($user->subscribedCommunities->count() > 0)
                        <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
                            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Communities
                            </h2>
                            <div class="space-y-2">
                                @foreach($user->subscribedCommunities->take(8) as $community)
                                    <a href="{{ route('communities.show', $community) }}" 
                                       class="block bg-zinc-800/50 hover:bg-zinc-800 border border-zinc-700/50 hover:border-orange-500/50 rounded-lg px-3 py-2 transition-all">
                                        <span class="text-orange-500 font-semibold text-sm">{{ $community->hashtag }}</span>
                                    </a>
                                @endforeach
                                @if($user->subscribedCommunities->count() > 8)
                                    <div class="bg-zinc-800/50 border border-zinc-700/50 rounded-lg px-3 py-2 text-zinc-500 text-sm text-center">
                                        +{{ $user->subscribedCommunities->count() - 8 }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Recent Posts -->
                    @if($recentPosts->count() > 0)
                        <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
                            <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Recent Posts
                            </h2>
                            <div class="space-y-3">
                                @foreach($recentPosts as $post)
                                    <a href="{{ route('communities.post', [$post->community, $post]) }}" 
                                       class="block bg-zinc-800/50 hover:bg-zinc-800 border border-zinc-700/50 hover:border-orange-500/50 rounded-lg p-3 transition-all">
                                        <p class="text-white font-medium text-sm line-clamp-2 mb-1">{{ $post->title }}</p>
                                        <div class="flex items-center gap-2 text-xs text-zinc-500">
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            <span>•</span>
                                            <span>{{ $post->likes_count }} ❤️</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Main Content - Profile Wall -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Write on Wall -->
                    @auth
                        <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
                            <h3 class="text-lg font-bold text-white mb-4">
                                {{ auth()->id() === $user->id ? 'Share something' : 'Write on ' . $user->name . "'s wall" }}
                            </h3>
                            <form method="POST" action="{{ route('profile.post', $user) }}">
                                @csrf
                                <textarea name="content" 
                                          rows="3" 
                                          class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                          placeholder="{{ auth()->id() === $user->id ? 'What\'s on your mind?' : 'Write something...' }}"
                                          required></textarea>
                                <div class="flex justify-end mt-3">
                                    <button type="submit" 
                                            class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-2 rounded-xl font-medium transition shadow-lg">
                                        Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endauth

                    <!-- Profile Wall Posts -->
                    <div class="space-y-4">
                        @forelse($profilePosts as $profilePost)
                            <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
                                <!-- Post Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ $profilePost->author->initials() }}
                                        </div>
                                        <div>
                                            <a href="{{ route('user.profile', $profilePost->author) }}" class="font-semibold text-white hover:text-orange-500 transition">
                                                {{ $profilePost->author->name }}
                                            </a>
                                            @if($profilePost->author_id !== $profilePost->user_id)
                                                <span class="text-zinc-500 text-sm">
                                                    → <a href="{{ route('user.profile', $profilePost->user) }}" class="hover:text-orange-500">{{ $profilePost->user->name }}</a>
                                                </span>
                                            @endif
                                            <p class="text-zinc-500 text-xs">{{ $profilePost->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @if(auth()->id() === $profilePost->author_id || auth()->id() === $profilePost->user_id)
                                        <form method="POST" action="{{ route('profile.post.delete', [$user, $profilePost]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-zinc-500 hover:text-red-500 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Post Content -->
                                <p class="text-zinc-300 mb-4">{{ $profilePost->content }}</p>

                                <!-- Comments Section -->
                                @if($profilePost->comments->count() > 0)
                                    <div class="border-t border-zinc-800 pt-4 mt-4 space-y-3">
                                        @foreach($profilePost->comments as $comment)
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                                    {{ $comment->user->initials() }}
                                                </div>
                                                <div class="flex-1 bg-zinc-800/50 rounded-lg p-3">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <a href="{{ route('user.profile', $comment->user) }}" class="font-semibold text-white text-sm hover:text-orange-500 transition">
                                                            {{ $comment->user->name }}
                                                        </a>
                                                        @if(auth()->id() === $comment->user_id)
                                                            <form method="POST" action="{{ route('profile.comment.delete', [$user, $profilePost, $comment]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-zinc-600 hover:text-red-500 transition text-xs">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                    <p class="text-zinc-300 text-sm">{{ $comment->content }}</p>
                                                    <p class="text-zinc-600 text-xs mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Comment Form -->
                                @auth
                                    <div class="border-t border-zinc-800 pt-4 mt-4">
                                        <form method="POST" action="{{ route('profile.comment', [$user, $profilePost]) }}" class="flex gap-2">
                                            @csrf
                                            <input type="text" 
                                                   name="content" 
                                                   class="flex-1 bg-zinc-800 border border-zinc-700 rounded-lg px-4 py-2 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm"
                                                   placeholder="Write a comment..."
                                                   required>
                                            <button type="submit" 
                                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm">
                                                Comment
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        @empty
                            <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-white mb-2">No posts yet</h3>
                                <p class="text-zinc-400">
                                    {{ auth()->id() === $user->id ? "Your wall is empty. Share your first post!" : "Be the first to write on " . $user->name . "'s wall!" }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sticky Footer -->
    <x-sticky-footer />
</x-layouts.app>
