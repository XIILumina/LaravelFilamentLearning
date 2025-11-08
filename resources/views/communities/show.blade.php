<x-layouts.app :title="$community->name">
    <!-- Community Header -->
    <div class="relative">
        <!-- Banner -->
        @if($community->banner_url)
            <div class="h-64 bg-cover bg-center" style="background-image: url('{{ $community->banner_url }}')">
                <div class="h-full bg-black bg-opacity-50"></div>
            </div>
        @else
            <div class="h-64 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
        @endif

        <!-- Community Info Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent">
            <div class="container mx-auto">
                <div class="flex items-end gap-6">
                    <!-- Community Icon -->
                    @if($community->icon_url)
                        <img src="{{ $community->icon_url }}" 
                             alt="{{ $community->name }}" 
                             class="w-24 h-24 rounded-xl object-cover border-4 border-white">
                    @else
                        <div class="w-24 h-24 bg-zinc-800 rounded-xl flex items-center justify-center border-4 border-white">
                            <span class="text-3xl">🎮</span>
                        </div>
                    @endif

                    <!-- Community Details -->
                    <div class="flex-1 min-w-0 pb-2">
                        <h1 class="text-4xl font-bold text-white mb-2">{{ $community->name }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-zinc-300">
                            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $community->hashtag }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ number_format($community->subscriber_count) }} members
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                {{ number_format($community->post_count) }} posts
                            </span>
                            <span class="text-zinc-400">Game: {{ $community->game->title }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @auth
                        <div class="flex gap-2 pb-2">
                            @if($isSubscribed)
                                <form method="POST" action="{{ route('communities.unsubscribe', $community) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-zinc-600 hover:bg-zinc-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Unsubscribe
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('communities.subscribe', $community) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Join Community
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('blog.create', ['community' => $community->id]) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                </svg>
                                Create Post
                            </a>
                        </div>
                    @else
                        <div class="pb-2">
                            <a href="{{ route('login') }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                                Login to Join
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Community Description -->
                @if($community->description)
                    <div class="bg-zinc-800 rounded-xl p-6 mb-6">
                        <h2 class="text-xl font-bold text-white mb-3">About this Community</h2>
                        <p class="text-zinc-300 leading-relaxed">{{ $community->description }}</p>
                    </div>
                @endif

                <!-- Posts Section -->
                <div class="bg-zinc-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white">Recent Posts</h2>
                        @auth
                            <a href="{{ route('blog.create', ['community' => $community->id]) }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Create Post
                            </a>
                        @endauth
                    </div>

                    @if($posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <article class="border-b border-zinc-700 last:border-b-0 pb-6 last:pb-0">
                                    <div class="flex gap-4">
                                        <!-- Author Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-zinc-700 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-zinc-300">
                                                    {{ substr($post->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Post Content -->
                                        <div class="flex-1 min-w-0">
                                            <!-- Post Header -->
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="font-medium text-white">{{ $post->user->name }}</span>
                                                <span class="text-zinc-500">•</span>
                                                <time class="text-zinc-500 text-sm">{{ $post->created_at->diffForHumans() }}</time>
                                                @if($post->game && $post->game->id !== $community->game_id)
                                                    <span class="text-zinc-500">•</span>
                                                    <span class="text-zinc-400 text-sm">{{ $post->game->title }}</span>
                                                @endif
                                            </div>

                                            <!-- Post Title and Content -->
                                            <h3 class="text-lg font-semibold text-white mb-2 hover:text-indigo-400 transition-colors">
                                                <a href="{{ route('communities.post', [$community, $post]) }}">{{ $post->title }}</a>
                                            </h3>

                                            @if($post->photo)
                                                <div class="mb-3">
                                                    <img src="{{ asset('storage/' . $post->photo) }}" 
                                                         alt="Post image" 
                                                         class="rounded-lg max-w-md max-h-64 object-cover">
                                                </div>
                                            @endif

                                            <div class="text-zinc-300 mb-3">
                                                <p>{{ Str::limit(strip_tags($post->content), 200) }}</p>
                                            </div>

                                            <!-- Post Actions -->
                                            <div class="flex items-center gap-4 text-sm text-zinc-400">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
                                                </span>
                                                <a href="{{ route('communities.post', [$community, $post]) }}" 
                                                   class="hover:text-indigo-400 transition-colors">
                                                    Read more
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <!-- No Posts -->
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <svg class="w-16 h-16 text-zinc-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-zinc-400 mb-2">No Posts Yet</h3>
                            <p class="text-zinc-500 mb-4">Be the first to start a discussion in this community!</p>
                            @auth
                                <a href="{{ route('blog.create', ['community' => $community->id]) }}" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                                    Create First Post
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                                    Login to Post
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Community Rules -->
                @if($community->rules && count($community->rules) > 0)
                    <div class="bg-zinc-800 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-bold text-white mb-4">Community Rules</h3>
                        <ol class="space-y-2">
                            @foreach($community->rules as $index => $ruleData)
                                <li class="text-zinc-300 text-sm">
                                    <span class="text-indigo-400 font-medium">{{ $index + 1 }}.</span>
                                    {{ $ruleData['rule'] ?? $ruleData }}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                <!-- Community Stats -->
                <div class="bg-zinc-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Community Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Members</span>
                            <span class="text-white font-medium">{{ number_format($community->subscriber_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Posts</span>
                            <span class="text-white font-medium">{{ number_format($community->post_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Game</span>
                            <span class="text-white font-medium">{{ $community->game->title }}</span>
                        </div>
                        @if($community->last_post_at)
                            <div class="flex justify-between">
                                <span class="text-zinc-400">Last Post</span>
                                <span class="text-white font-medium">{{ $community->last_post_at->diffForHumans() }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-zinc-400">Created</span>
                            <span class="text-white font-medium">{{ $community->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>