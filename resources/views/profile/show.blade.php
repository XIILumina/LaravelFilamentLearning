<x-layouts.app :title="$user->name . ' - Profile'">
    <div class="min-h-screen bg-zinc-950 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-zinc-900 rounded-lg border border-zinc-800 p-8 mb-6">
                <div class="flex items-start gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <x-avatar :user="$user" size="xl" class="shadow-xl" />
                    </div>

                    <!-- User Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                            @if($user->role === 'admin')
                                <span class="bg-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Admin</span>
                            @endif
                        </div>
                        @if($user->username)
                            <p class="text-lg text-zinc-400 mb-4">@{{ $user->username }}</p>
                        @endif
                        <p class="text-zinc-500 text-sm mb-4">Member since {{ $user->created_at->format('F Y') }}</p>

                        <!-- Stats -->
                        <div class="flex items-center gap-6">
                            <div>
                                <span class="text-2xl font-bold text-white">{{ $stats['posts'] }}</span>
                                <span class="text-zinc-400 text-sm ml-1">Posts</span>
                            </div>
                            <div>
                                <span class="text-2xl font-bold text-white">{{ $stats['comments'] }}</span>
                                <span class="text-zinc-400 text-sm ml-1">Comments</span>
                            </div>
                            <div>
                                <span class="text-2xl font-bold text-white">{{ $stats['communities'] }}</span>
                                <span class="text-zinc-400 text-sm ml-1">Communities</span>
                            </div>
                            <div>
                                <span class="text-2xl font-bold text-orange-500">{{ $stats['likes_received'] }}</span>
                                <span class="text-zinc-400 text-sm ml-1">Likes</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit') }}" 
                               class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Edit Profile
                            </a>
                        @else
                            <a href="{{ route('messages.show', $user) }}" 
                               class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Message
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Subscribed Communities -->
            @if($user->subscribedCommunities->count() > 0)
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-white mb-4">Subscribed Communities</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->subscribedCommunities->take(10) as $community)
                            <a href="{{ route('communities.show', $community) }}" 
                               class="bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 hover:border-orange-500/50 rounded-lg px-4 py-2 transition-all">
                                <span class="text-orange-500 font-semibold">{{ $community->hashtag }}</span>
                            </a>
                        @endforeach
                        @if($user->subscribedCommunities->count() > 10)
                            <span class="bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-2 text-zinc-500">
                                +{{ $user->subscribedCommunities->count() - 10 }} more
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Posts Section -->
            <div>
                <h2 class="text-xl font-bold text-white mb-4">
                    {{ auth()->id() === $user->id ? 'Your Posts' : $user->name . "'s Posts" }}
                </h2>

                @if($posts->count() > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <a href="{{ route('communities.post', [$post->community, $post]) }}" 
                               class="block bg-zinc-900 rounded-lg p-6 hover:bg-zinc-850 transition-all border border-zinc-800 hover:border-orange-500/50">
                                <!-- Community Badge -->
                                @if($post->community)
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-sm text-orange-500 font-medium">{{ $post->community->hashtag }}</span>
                                        <span class="text-zinc-600">•</span>
                                        <span class="text-sm text-zinc-500">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                @endif

                                <!-- Post Title -->
                                <h3 class="text-xl font-semibold text-white mb-2">{{ $post->title }}</h3>

                                <!-- Post Preview -->
                                @if($post->content)
                                    <p class="text-zinc-400 line-clamp-2 mb-4">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                                @endif

                                <!-- Post Meta -->
                                <div class="flex items-center gap-6 text-sm text-zinc-500">
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
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="bg-zinc-900 rounded-lg p-12 text-center border border-zinc-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-white mb-2">No posts yet</h3>
                        <p class="text-zinc-400">
                            {{ auth()->id() === $user->id ? "Start sharing your thoughts with the community!" : "This user hasn't posted anything yet." }}
                        </p>
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('blog.create') }}" 
                               class="inline-block mt-4 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Create Your First Post
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
