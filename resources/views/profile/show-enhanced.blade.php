<x-layouts.app :title="$user->name . ' - Profile'">
    <div class="min-h-screen bg-zinc-950 py-8 pb-96">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-600 text-white px-6 py-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Header with Banner -->
            <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 rounded-2xl border border-zinc-800 overflow-hidden mb-6">
                <!-- Banner Section -->
                <div class="relative h-48 bg-gradient-to-r from-orange-500/20 to-red-600/20">
                    @if($user->profileBannerUrl())
                        <img src="{{ $user->profileBannerUrl() }}" 
                             alt="Profile banner" 
                             class="w-full h-full object-cover">
                    @endif
                    
                    @if(auth()->id() === $user->id)
                        <div class="absolute top-4 right-4 flex gap-2">
                            <!-- Upload Banner Button -->
                            <form action="{{ route('profile.banner.update') }}" method="POST" enctype="multipart/form-data" id="profileBannerForm">
                                @csrf
                                <label for="profile_banner" class="bg-black/60 hover:bg-black/80 text-white px-4 py-2 rounded-lg cursor-pointer transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->profile_banner ? 'Change' : 'Add' }} Banner
                                </label>
                                <input type="file" id="profile_banner" name="profile_banner" accept="image/*" class="hidden" onchange="document.getElementById('profileBannerForm').submit()">
                            </form>
                            
                            @if($user->profile_banner)
                                <form action="{{ route('profile.banner.delete') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600/80 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2" title="Remove banner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Profile Info Section -->
                <div class="p-8">
                    <div class="flex flex-col md:flex-row items-start gap-6">
                        <!-- Avatar -->
                        <div class="flex-shrink-0 relative group -mt-20">
                            <x-avatar :user="$user" size="2xl" class="shadow-2xl ring-4 ring-zinc-900" />
                            
                            @if(auth()->id() === $user->id)
                                <!-- Upload/Change Photo Button -->
                                <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                                    @csrf
                                    <label for="profile_picture" class="absolute inset-0 flex items-center justify-center bg-black/60 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </label>
                                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden" onchange="document.getElementById('profilePictureForm').submit()">
                                </form>
                                
                                @if($user->profile_picture)
                                    <form action="{{ route('profile.picture.delete') }}" method="POST" class="absolute -bottom-2 -right-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 shadow-lg transition-colors" title="Remove picture">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endif
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
                            <p class="text-xl text-zinc-400 mb-4">{{ '@' . $user->username }}</p>
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
                                        <x-avatar :user="$profilePost->author" size="md" />
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
                                                <x-avatar :user="$comment->user" size="sm" />
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
