<x-layouts.app title="Communities">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">Gaming Communities</h1>
            <p class="text-zinc-400 text-lg">
                Join communities of passionate gamers, share your experiences, and discover new content!
            </p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-zinc-800 rounded-xl p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search communities..." 
                           class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-4 py-2 text-white placeholder-zinc-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg text-white font-medium transition-colors">
                        Search
                    </button>
                    @if(request()->anyFilled(['search']))
                        <a href="{{ route('communities.index') }}" 
                           class="bg-zinc-600 hover:bg-zinc-700 px-4 py-2 rounded-lg text-white font-medium transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Communities Grid -->
        @if($communities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($communities as $community)
                    <div class="bg-zinc-800 rounded-xl overflow-hidden hover:bg-zinc-750 transition-colors group">
                        <!-- Community Banner -->
                        @if($community->banner_url)
                            <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $community->banner_url }}')">
                                <div class="h-full bg-black bg-opacity-40"></div>
                            </div>
                        @else
                            <div class="h-32 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
                        @endif

                        <!-- Community Content -->
                        <div class="p-6">
                            <!-- Icon and Basic Info -->
                            <div class="flex items-start gap-4 mb-4">
                                @if($community->icon_url)
                                    <img src="{{ $community->icon_url }}" 
                                         alt="{{ $community->name }}" 
                                         class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 bg-zinc-700 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl">🎮</span>
                                    </div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-bold text-white mb-1 truncate">{{ $community->name }}</h3>
                                    <span class="inline-block bg-indigo-600 text-white text-sm px-2 py-1 rounded-full mb-2">
                                        {{ $community->hashtag }}
                                    </span>
                                    <p class="text-zinc-400 text-sm">{{ $community->game->title }}</p>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($community->description)
                                <p class="text-zinc-400 text-sm mb-4 line-clamp-3">{{ $community->description }}</p>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-zinc-400 mb-4">
                                <div class="flex items-center gap-4">
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
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('communities.show', $community) }}" 
                                   class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-center font-medium transition-colors group-hover:bg-indigo-700">
                                    View Community
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $communities->withQueryString()->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-zinc-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-zinc-400 mb-2">No Communities Found</h3>
                <p class="text-zinc-500 mb-6">
                    @if(request('search'))
                        No communities match your search criteria.
                    @else
                        There are no communities available yet.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('communities.index') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors inline-block">
                        View All Communities
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-layouts.app>