<x-layouts.app title="Communities">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-6 border-b border-zinc-800/50">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-1">Communities</h1>
                <p class="text-zinc-400 text-sm sm:text-base">Join communities and connect with fellow gamers</p>
            </div>
        </div>

        <!-- Search -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4">
            <form method="GET" class="flex gap-2">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search communities..." 
                           class="w-full bg-zinc-800/50 border border-zinc-700/50 rounded-xl pl-10 pr-4 py-2.5 text-white text-sm placeholder-zinc-500 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition-all">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-orange-500 hover:bg-orange-600 rounded-xl text-white text-sm font-medium transition-colors">
                    Search
                </button>
                @if(request()->anyFilled(['search']))
                    <a href="{{ route('communities.index') }}" class="px-4 py-2.5 bg-zinc-800 hover:bg-zinc-700 rounded-xl text-zinc-300 text-sm font-medium transition-colors">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Communities Grid -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4">
            @if($communities->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($communities as $community)
                        <a href="{{ route('communities.show', $community) }}" 
                           class="block bg-zinc-800/30 border border-zinc-700/30 rounded-2xl overflow-hidden hover:border-zinc-600/50 transition-all group">
                            
                            <!-- Banner -->
                            <div class="h-20 relative">
                                @if($community->banner_url)
                                    <img src="{{ $community->banner_url }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-500/30 to-orange-600/30"></div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-4 -mt-8 relative">
                                <!-- Icon -->
                                <div class="mb-3">
                                    @if($community->icon_url)
                                        <img src="{{ $community->icon_url }}" 
                                             alt="{{ $community->name }}" 
                                             class="w-14 h-14 rounded-xl border-4 border-zinc-900 object-cover">
                                    @else
                                        <div class="w-14 h-14 rounded-xl border-4 border-zinc-900 bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-xl">
                                            🎮
                                        </div>
                                    @endif
                                </div>

                                <!-- Info -->
                                <h3 class="font-semibold text-white group-hover:text-orange-400 transition-colors mb-1 line-clamp-1">
                                    {{ $community->name }}
                                </h3>
                                <span class="inline-block text-xs text-orange-400 mb-2">{{ $community->hashtag }}</span>

                                @if($community->description)
                                    <p class="text-sm text-zinc-400 line-clamp-2 mb-3">{{ $community->description }}</p>
                                @endif

                                <!-- Stats -->
                                <div class="flex items-center gap-4 text-xs text-zinc-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                        </svg>
                                        {{ number_format($community->subscriber_count) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ number_format($community->post_count) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $communities->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-zinc-800 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No communities found</h3>
                    <p class="text-zinc-500 text-sm">Try adjusting your search or check back later.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
